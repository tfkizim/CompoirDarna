<?php
namespace WhatsappBundle\Libaxolotl\State;
class UnacknowledgedPreKeyMessageItems
{
    public function UnacknowledgedPreKeyMessageItems($preKeyId, $signedPreKeyId, $baseKey)
    {
        /*
        :type preKeyId: int
        :type signedPreKeyId: int
        :type baseKey: ECPublicKey
        */
        $this->preKeyId = $preKeyId;
        $this->signedPreKeyId = $signedPreKeyId;
        $this->baseKey = $baseKey;
    }

    public function getPreKeyId()
    {
        return $this->preKeyId;
    }

    public function getSignedPreKeyId()
    {
        return $this->signedPreKeyId;
    }

    public function getBaseKey()
    {
        return $this->baseKey;
    }
}
