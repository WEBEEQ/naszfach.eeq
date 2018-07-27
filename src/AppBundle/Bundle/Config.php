<?php
// src/AppBundle/Bundle/Config.php
namespace AppBundle\Bundle;

class Config
{
    protected $url;
    protected $serverName;
    protected $serverDomain;
    protected $remoteAddress;
    protected $dateTimeNow;
    protected $adminEmail;

    public function __construct()
    {
        $this->url = 'http' . (($_SERVER['SERVER_PORT'] == 443) ? 's://' : '://') . $_SERVER['HTTP_HOST'];
        $this->serverName = $_SERVER['SERVER_NAME'];
        $this->serverDomain = str_replace('www.', '', $_SERVER['SERVER_NAME']);
        $this->remoteAddress = $_SERVER['REMOTE_ADDR'];
        $this->dateTimeNow = new \DateTime('now');
        $this->adminEmail = 'symfony20160510@gmail.com';
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setServerName($serverName)
    {
        $this->serverName = $serverName;
    }

    public function getServerName()
    {
        return $this->serverName;
    }

    public function setServerDomain($serverDomain)
    {
        $this->serverDomain = $serverDomain;
    }

    public function getServerDomain()
    {
        return $this->serverDomain;
    }

    public function setRemoteAddress($remoteAddress)
    {
        $this->remoteAddress = $remoteAddress;
    }

    public function getRemoteAddress()
    {
        return $this->remoteAddress;
    }

    public function setDateTimeNow($dateTimeNow)
    {
        $this->dateTimeNow = $dateTimeNow;
    }

    public function getDateTimeNow()
    {
        return $this->dateTimeNow;
    }

    public function setAdminEmail($adminEmail)
    {
        $this->adminEmail = $adminEmail;
    }

    public function getAdminEmail()
    {
        return $this->adminEmail;
    }
}
