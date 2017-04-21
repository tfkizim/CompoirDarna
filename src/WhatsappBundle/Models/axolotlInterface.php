<?php
namespace WhatsappBundle\Models;
interface axolotlInterface
{
    //PreKeys

    public function storePreKey($prekeyId, $preKeyRecord);

    public function loadPreKey($preKeyId);

    public function loadPreKeys();

    public function containsPreKey($preKeyId);

    public function removePreKey($preKeyId);

    public function removeAllPreKeys();

    //signedPreKey

    public function storeSignedPreKey($signedPreKeyId, $signedPreKeyRecord);

    public function loadSignedPreKey($signedPreKeyId);

    public function loadSignedPreKeys();

    public function removeSignedPreKey($signedPreKeyId);

    public function containsSignedPreKey($signedPreKeyId);

    //identity

    public function storeLocalData($registrationId, $identityKeyPair);

    public function getIdentityKeyPair();

    public function getLocalRegistrationId();

    public function isTrustedIdentity($recipientId, $identityKey);

    public function saveIdentity($recipientId, $identityKey);

    public function clearRecipient($recipientId);

    //session

    public function storeSession($recipientId, $deviceId, $sessionRecord);

    public function loadSession($recipientId, $deviceId);

    public function getSubDeviceSessions($recipientId);

    public function containsSession($recipientId, $deviceId);

    public function deleteSession($recipientId, $deviceId);

    public function deleteAllSessions($recipientId);

    //sender_keys

    public function storeSenderKey($senderKeyId, $senderKeyRecord);

    public function loadSenderKey($senderKeyId);

    public function removeSenderKey($senderKeyId);

    public function containsSenderKey($senderKeyId);

    public function clear();
}