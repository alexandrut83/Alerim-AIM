<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/reward_calculation.php';

class MiningProxy {
    private $config;
    private $clients = [];
    private $upstream = [];
    private $rewardCalculator;

    public function __construct($pdo) {
        $this->config = require __DIR__ . '/proxy_config.php';
        $this->rewardCalculator = new RewardCalculator($pdo);
    }

    public function start() {
        foreach ($this->config['proxy']['listen'] as $algo => $bind) {
            $this->startAlgoProxy($algo, $bind);
        }
    }

    private function startAlgoProxy($algo, $bind) {
        list($host, $port) = explode(':', $bind);
        $server = stream_socket_server("tcp://$bind", $errno, $errstr);
        if (!$server) {
            error_log("Failed to create proxy server for $algo: $errstr ($errno)");
            return;
        }

        // Connect to upstream pool
        $pool = $this->config['pools'][$algo]['primary'];
        $upstream = stream_socket_client(
            "tcp://{$pool['host']}:{$pool['port']}", 
            $errno, 
            $errstr, 
            30
        );

        if (!$upstream) {
            error_log("Failed to connect to upstream pool for $algo: $errstr ($errno)");
            return;
        }

        $this->upstream[$algo] = $upstream;

        // Subscribe to upstream pool
        $this->poolSubscribe($algo, $upstream);

        // Handle incoming connections
        while ($client = stream_socket_accept($server, -1)) {
            $this->handleClient($algo, $client);
        }
    }

    private function poolSubscribe($algo, $upstream) {
        $pool = $this->config['pools'][$algo]['primary'];
        
        // Mining subscribe
        $subscribe = json_encode([
            'id' => 1,
            'method' => 'mining.subscribe',
            'params' => [$pool['user'], 'alerim-proxy/1.0.0']
        ]) . "\n";
        fwrite($upstream, $subscribe);

        // Mining authorize
        $authorize = json_encode([
            'id' => 2,
            'method' => 'mining.authorize',
            'params' => [$pool['user'], $pool['pass']]
        ]) . "\n";
        fwrite($upstream, $authorize);
    }

    private function handleClient($algo, $client) {
        $clientId = uniqid();
        $this->clients[$clientId] = [
            'socket' => $client,
            'algo' => $algo,
            'shares' => 0
        ];

        // Handle client messages
        while (!feof($client)) {
            $data = fgets($client);
            if ($data === false) {
                break;
            }

            $message = json_decode($data, true);
            if (!$message) {
                continue;
            }

            // Modify the message to use our pool credentials
            if ($message['method'] === 'mining.authorize') {
                $pool = $this->config['pools'][$algo]['primary'];
                $message['params'][0] = $pool['user'];
                $message['params'][1] = $pool['pass'];
            }

            // Forward modified message to upstream
            fwrite($this->upstream[$algo], json_encode($message) . "\n");

            // Track shares for reward calculation
            if ($message['method'] === 'mining.submit') {
                $this->clients[$clientId]['shares']++;
                $this->processShare($algo, $clientId);
            }
        }

        // Cleanup
        unset($this->clients[$clientId]);
        fclose($client);
    }

    private function processShare($algo, $clientId) {
        // Calculate rewards based on the share
        $client = $this->clients[$clientId];
        
        // Get current crypto prices and calculate reward
        $prices = $this->getCurrentPrices();
        foreach ($prices as $currency => $price) {
            $reward = $this->rewardCalculator->calculateReward($currency, 0.00001, $price);
            
            // Record the reward (using a placeholder user ID 1)
            $this->rewardCalculator->recordReward(
                1,
                $currency,
                0.00001,
                $reward['original_value'],
                $reward['aim_tokens'],
                $reward['gold_price']
            );
        }
    }

    private function getCurrentPrices() {
        // In production, implement real API calls
        return [
            'BTC' => 76932.45,
            'ETH' => 3850.75
        ];
    }
}

// Start the proxy server
$proxy = new MiningProxy($pdo);
$proxy->start();
