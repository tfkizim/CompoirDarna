<?php
namespace WhatsappBundle\Models;
interface MessageStoreInterface
{
    public function saveMessage($from, $to, $txt, $id, $t);
}