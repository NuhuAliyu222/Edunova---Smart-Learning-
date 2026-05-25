<?php
class AuthMiddleware {
    private $secret_key = "edunova_secret_key_2024";
    
    public function generateJWT($user_id, $email, $role) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode([
            'user_id' => $user_id,
            'email' => $email,
            'role' => $role,
            'exp' => time() + (7 * 24 * 60 * 60)
        ]);
        
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secret_key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }
    
    public function verifyJWT($token) {
        try {
            $tokenParts = explode('.', $token);
            if(count($tokenParts) != 3) return false;
            
            $payload = base64_decode($tokenParts[1]);
            $decoded = json_decode($payload);
            
            if($decoded->exp < time()) return false;
            
            return (array)$decoded;
        } catch(Exception $e) {
            return false;
        }
    }
}
?>
