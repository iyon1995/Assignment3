<?php

/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/28/2018
 * Time: 5:56 PM
 * Version:
 * Description:
 */
class Message
{
    private $messId;
    private $roomId;
    private $sender;
    private $receiver;
    private $content;
    private $sendTime;
    private $isRead;

    public function __construct()
    {
        $a=func_get_args();
        $i=func_num_args();
        if(method_exists($this,$f='__construct'.$i)){
            call_user_func_array(array($this,$f),$a);
        }
    }

    /**
     * Message constructor.
     * @param $messId
     * @param $roomId
     * @param $sender
     * @param $receiver
     * @param $content
     * @param $sendTime
     */
    public function __construct6($messId, $roomId, $sender, $receiver, $content, $sendTime)
    {
        $this->messId = $messId;
        $this->roomId = $roomId;
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->content = $content;
        $this->sendTime = $sendTime;
    }

    /**
     * @return mixed
     */
    public function getMessId()
    {
        return $this->messId;
    }

    /**
     * @param mixed $messId
     */
    public function setMessId($messId)
    {
        $this->messId = $messId;
    }

    /**
     * @return mixed
     */
    public function getRoomId()
    {
        return $this->roomId;
    }

    /**
     * @param mixed $roomId
     */
    public function setRoomId($roomId)
    {
        $this->roomId = $roomId;
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param mixed $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return mixed
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param mixed $receiver
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getSendTime()
    {
        return $this->sendTime;
    }

    /**
     * @param mixed $sendTime
     */
    public function setSendTime($sendTime)
    {
        $this->sendTime = $sendTime;
    }

    /**
     * @return mixed
     */
    public function getisRead()
    {
        return $this->isRead;
    }

    /**
     * @param mixed $isRead
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;
    }


}