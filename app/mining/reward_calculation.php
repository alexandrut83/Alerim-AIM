<?php
require_once __DIR__ . '/../config.php';

class RewardCalculator {
    private $pdo;
    private $reduction_percentage;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->reduction_percentage = REWARD_REDUCTION_PERCENTAGE;
    }

    /**
     * Calculate AIM reward based on mined cryptocurrency
     */
    public function calculateReward($currency, $amount, $currentPrice) {
        // Calculate original value in USD
        $originalValue = $amount * $currentPrice;
        
        // Apply reduction percentage
        $reducedValue = $originalValue * (1 - ($this->reduction_percentage / 100));
        
        // Get current gold price per gram
        $goldPrice = $this->getGoldPrice();
        
        // Calculate AIM tokens (reduced value divided by gold price)
        $aimTokens = $reducedValue / $goldPrice;
        
        return [
            'original_value' => $originalValue,
            'reduced_value' => $reducedValue,
            'gold_price' => $goldPrice,
            'aim_tokens' => $aimTokens
        ];
    }

    /**
     * Get current gold price per gram
     */
    private function getGoldPrice() {
        // In a production environment, implement API call to get real-time gold price
        // For now, using a placeholder value
        return 69.50; // Current gold price per gram in GBP
    }

    /**
     * Record mining reward in database
     */
    public function recordReward($userId, $currency, $amount, $valueUsd, $aimAmount, $goldPrice) {
        $stmt = $this->pdo->prepare("
            INSERT INTO mining_rewards 
            (user_id, original_currency, original_amount, original_value_usd, aim_amount, gold_price_per_gram)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $userId,
            $currency,
            $amount,
            $valueUsd,
            $aimAmount,
            $goldPrice
        ]);
    }

    /**
     * Update user's wallet balance
     */
    public function updateWalletBalance($userId, $aimAmount) {
        $stmt = $this->pdo->prepare("
            UPDATE wallets 
            SET balance = balance + ? 
            WHERE user_id = ?
        ");
        
        return $stmt->execute([$aimAmount, $userId]);
    }
}
