<?php

/**
 * Hava Durumu Sorgulaması İçin Class
 * 
 * @author Süleyman DENİZHAN <ayem@suleymandenizhan.com.tr>
 * @link http://github.com/sDenizhan
 * @version 1.0
 * 
 */
class WWO
{

    /**
     * API URL
     * @var type 
     */
    private $_freeApiURL = 'http://api.worldweatheronline.com/free/v2/weather.ashx';
    
    /**
     *  API Ayarları Değişkeni
     * @var type 
     */
    public $_ayarlar = array(
        'format' => 'json',
        'lang' => 'tr',
        'tp' => '24'
    );
    
    /**
     * API İçeriği
     * @var type 
     */
    private $content = null;
    
    function __construct()
    {}

    /**
     * Api İçin Ayarlar
     * @param type $options
     */
    function set_ayarlar( $options = array() )
    {
        if ( count($options) > 0 )
        {
            foreach ($options as $key => $value) {
                $this->_ayarlar[$key] = $value;
            }
        }
    }
    
    /**
     * Bölgeyi Set Eder...
     * @param strıng $location
     */
    function q($location = 'Istanbul,Turkey')
    {
        if ( empty($location) )
        {
            $location = 'Istanbul,Turkey';
        }
        else
        {
            $this->_ayarlar['q'] = urlencode($location);
        }
        return $this;
    }

    /**
     * Api Anahtarını Set Eder.. Gereklidir...
     * @param type $key
     */
    function key($key)
    {
        if ( empty($key) )
        {
            die('Api Anahtarını Girmelisiniz..!');
        }
        else
        {
            $this->_ayarlar['key'] = $key;
        }
        return $this;
    }
    
    /**
     * Hava Durumu İçin Tarihi Set Eder..
     * @param type $date
     * @return \WorldWeatherOnline
     */
    function date($date)
    {
        if ( empty($date) )
        {
            $this->_ayarlar['date'] = 'today';
        }
        else
        {
            $this->_ayarlar['date'] = $date;
        }
        
        return $this;
    }
    
    /**
     * Api Ayarlarını Ekler...
     * 
     * @param type $key
     * @param type $val
     * @return boolean
     */
    function ayar_ekle($key, $val)
    {
        if ( !empty($key) || !empty($val))
        {
            $this->_ayarlar[$key] = $val;
        }
        
        return $this;
        
    }
    
    /**
     * Datayı Alır
     * 
     * @param type $ayarlar
     */
    function run()
    {
        if ( count($this->_ayarlar) > 0 )
        {
            $link = $this->_freeApiURL.'?'.http_build_query($this->_ayarlar);
        }
        else
        {
            $link = $this->_freeApiURL;
        }
        
        $this->content = file_get_contents($link);
        
        return $this;
    }

    /**
     * Çekilen İçeriğe Erişim Sağlar
     * 
     * @return type
     */
    function getData( $data = 'weather')
    {
        if ( empty($data) )
        {
            $data = 'weather';
        }
        
        if ( $this->content != null )
        {
            //eğer sorgu json ise
            $content = json_decode($this->content, 1);
            
            return $this->content = $content['data'][$data][0];
                        
        }
        else
        {
            return false;
        }
    }

    function getMaxC()
    {
        return $this->content['maxtempC'];
    }
    
    function getMinC()
    {
        return $this->content['mintempC'];
    }
    
    function getText()
    {
        return $this->content['hourly'][0]['lang_tr'][0]['value'];
    }
    
    function getIcon()
    {
        return $this->content['hourly'][0]['weatherIconUrl'][0]['value'];
    }

}
