<?php
Class NV_Cache
{
    private $cache;
    private $cachetime = 7; // days
    
    public function __construct($cache_dir=null)
    {
        if( !is_null($cache_dir) )
        {
            $this->cache = $cache_dir;
        }
    }
    
    /*
     * Cache dosyasından okur!
    */
    public function _oku_cache($dosya)
    {
    	return json_decode( file_get_contents( $this->cache . $dosya ) );
    }
    	
    /*
     * Cache dosyası var mı yok mu onu sorgular!
    */
    public function _sor_cache($file)
    {
    	if( file_exists( $this->cache . $file ) )
    	{
    		$zaman = time() - ($this->cachetime * 86400) - 1;
    		if ( filemtime( $this->cache . $file ) > $zaman )
    		{
    			if ( ((int) date('m',filemtime($this->cache . $file) )) != ((int)date('m')) )
				{
					return false;
				}
				return true;
    		} else {
    			return false;
    		}
    	} else {
    		return false;
    	}
    }	
    
    /*
     * Cache dosyası oluşturur!
    */
    public function _yaz_cache($dosya, $veri)
    {
    	$fp = fopen( $this->cache . $dosya, 'w' );
    	fputs($fp,$veri);
    	fclose($fp);
    }
}