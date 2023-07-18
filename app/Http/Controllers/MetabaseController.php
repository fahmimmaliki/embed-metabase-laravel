<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class MetabaseController extends Controller
{
    public function generateToken()
    {
        $METABASE_SITE_URL = env('METABASE_SITE_URL');
        $METABASE_SECRET_KEY = env('METABASE_SECRET_KEY');

        $questionId = 1; // Replace 1 with the actual question ID as an integer

        $config = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText($METABASE_SECRET_KEY));

        $now = new \DateTimeImmutable();
        $exp = $now->modify('+10 minutes');

        $params = new \stdClass(); // Use an empty stdClass object

        $token = $config->builder()
            ->issuedBy($METABASE_SITE_URL)
            ->permittedFor($METABASE_SITE_URL)
            ->identifiedBy(bin2hex(random_bytes(16)))
            ->withClaim('resource', ['question' => $questionId]) // Use the actual question ID as an integer
            ->withClaim('params', $params) // Use the object instead of the array
            ->issuedAt($now)
            ->expiresAt($exp) // Use the DateTimeImmutable object for expiration
            ->getToken($config->signer(), $config->signingKey());

        $iframeUrl = $METABASE_SITE_URL . "/embed/question/" . $token->toString() . "#bordered=true&titled=true";

        // Pass the iframe URL to the 'metabase' view
        return view('metabase', compact('iframeUrl'));
    }
}
