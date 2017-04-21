<?php
namespace WhatsappBundle\Models;
use WhatsappBundle\Models\ProtocolNode;
interface NewMsgBindInterface
{
    public function process(ProtocolNode $node);
}
