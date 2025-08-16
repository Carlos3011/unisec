<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebPayController extends Controller
{
    /**
     * Recibe la notificación POST desde WebPay Plus
     */
    public function notify(Request $request)
    {
        // 1. Recuperar parámetro cifrado
        $encryptedResponse = $request->input('strResponse');

        if (!$encryptedResponse) {
            Log::error("WebPay: strResponse no recibido.");
            return response('Faltan datos', 400);
        }

        // 2. Decodificar URL
        $decodedResponse = urldecode($encryptedResponse);

        // 3. Desencriptar usando AES-128
        $decryptedXml = $this->decryptWebPay($decodedResponse);

        if (!$decryptedXml) {
            Log::error("WebPay: Error al desencriptar respuesta.");
            return response('Error de descifrado', 500);
        }

        // 4. Procesar XML
        $xml = simplexml_load_string($decryptedXml);

        if (!$xml) {
            Log::error("WebPay: XML mal formado: " . $decryptedXml);
            return response('XML inválido', 422);
        }

        // 5. Guardar información importante (ajusta según tus necesidades)
        $reference = (string) $xml->reference ?? null;
        $amount = (string) $xml->amount ?? null;
        $authCode = (string) $xml->auth ?? null;
        $folioPagos = (string) $xml->foliocpagos ?? null;
        $maskedCard = (string) $xml->cc_mask ?? null;
        $responseType = (string) $xml->response ?? null;

        Log::info("WebPay: Transacción recibida", [
            'reference' => $reference,
            'amount' => $amount,
            'auth' => $authCode,
            'folio' => $folioPagos,
            'card' => $maskedCard,
            'response' => $responseType,
        ]);

        // Aquí puedes guardar los datos en tu base de datos si lo deseas.

        return response('OK', 200);
    }

    /**
     * Vista mostrada al usuario tras redirección (opcional)
     */
    public function result(Request $request)
    {
        return view('webpay.result'); // Crea esta vista en /resources/views/webpay/result.blade.php
    }

    /**
     * Genera la cadena XML para WebPay Plus
     */
    public function generateXmlString()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<P>' . "\n";
        $xml .= '  <business>' . "\n";
        $xml .= '    <id_company>' . env('WEBPAY_ID_COMPANY') . '</id_company>' . "\n";
        $xml .= '    <id_branch>' . env('WEBPAY_ID_BRANCH') . '</id_branch>' . "\n";
        $xml .= '    <user>' . env('WEBPAY_USER') . '</user>' . "\n";
        $xml .= '    <pwd>' . env('WEBPAY_PASSWORD') . '</pwd>' . "\n";
        $xml .= '  </business>' . "\n";
        $xml .= '  <url>' . "\n";
        $xml .= '    <reference>FACTURA999</reference>' . "\n";
        $xml .= '    <amount>1.00</amount>' . "\n";
        $xml .= '    <moneda>MXN</moneda>' . "\n";
        $xml .= '    <canal>W</canal>' . "\n";
        $xml .= '    <omitir_notif_default>1</omitir_notif_default>' . "\n";
        $xml .= '    <datos_adicionales>' . "\n";
        $xml .= '      <data id="1" display="true">' . "\n";
        $xml .= '        <label>Talla</label>' . "\n";
        $xml .= '        <value>Grande</value>' . "\n";
        $xml .= '      </data>' . "\n";
        $xml .= '      <data id="2" display="false">' . "\n";
        $xml .= '        <label>Color</label>' . "\n";
        $xml .= '        <value>Azul</value>' . "\n";
        $xml .= '      </data>' . "\n";
        $xml .= '    </datos_adicionales>' . "\n";
        $xml .= '    <version>IntegraWPP</version>' . "\n";
        $xml .= '  </url>' . "\n";
        $xml .= '</P>';

        // Cifrar el XML con AES-128
        $encryptedXml = $this->encryptAES128($xml);

        // Imprimir XML original y cifrado en consola para debug
        dd([
            'xml_original' => $xml,
            'xml_cifrado' => $encryptedXml
        ]);

        return $encryptedXml;
    }

    /**
     * Cifra una cadena usando AES-128-CBC
     */
    private function encryptAES128($data)
    {
        $key = env('WEBPAY_AES_KEY', 'defaultkey123456'); // Clave de 16 caracteres para AES-128
        $method = 'AES-128-CBC';
        $iv = openssl_random_pseudo_bytes(16); // Vector de inicialización de 16 bytes
        
        // Asegurar que la clave tenga exactamente 16 caracteres
        $key = substr(str_pad($key, 16, '0'), 0, 16);
        
        // Cifrar los datos
        $encrypted = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv);
        
        // Combinar IV + datos cifrados y codificar en base64
        return base64_encode($iv . $encrypted);
    }

    /**
     * Descifra una cadena cifrada con AES-128-CBC
     */
    private function decryptAES128($encryptedData)
    {
        $key = env('WEBPAY_AES_KEY', 'defaultkey123456');
        $method = 'AES-128-CBC';
        
        // Asegurar que la clave tenga exactamente 16 caracteres
        $key = substr(str_pad($key, 16, '0'), 0, 16);
        
        // Decodificar de base64
        $data = base64_decode($encryptedData);
        
        // Extraer IV (primeros 16 bytes) y datos cifrados
        $iv = substr($data, 0, 16);
        $encrypted = substr($data, 16);
        
        // Descifrar
        return openssl_decrypt($encrypted, $method, $key, OPENSSL_RAW_DATA, $iv);
    }

    /**
     * Función para desencriptar strResponse con AES-128-ECB
     */
    private function decryptWebPay($cipher)
    {
        try {
            $aesKey = config('webpay.aes_key'); // Llave AES en config/webpay.php
            $binaryKey = hex2bin($aesKey);

            $decrypted = openssl_decrypt(base64_decode($cipher), 'aes-128-ecb', $binaryKey, OPENSSL_RAW_DATA);
            return $decrypted;
        } catch (\Exception $e) {
            Log::error("WebPay: Error en desencriptado - " . $e->getMessage());
            return null;
        }
    }
}