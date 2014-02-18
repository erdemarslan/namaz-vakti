<?php

/**
 * Namaz - Diyanet İşleri Başkanlığından veri çekme sınıfı
 *
 * @author		Erdem ARSLAN (http://www.erdemarslan.com/)
 * @copyright	Copyright (c) 2014 erdemarslan.com
 * @link		http://www.erdemarslan.com/programlama/php-programlama/06-01-2014/563-namaz-vakitleri-php-sinifi.html
 * @version     4.0
 */

Class Namaz
{
	
	protected $ulke		= 'TURKIYE';
	protected $sehir	= 'CANAKKALE';
	protected $ilce		= 'CANAKKALE';
	
	protected $cache_klasoru = 'cache';
	protected $cache;
	
	protected $ulkeler = array('ABD' => 'ABD', 'AFGANISTAN' => 'AFGANISTAN', 'ALMANYA' => 'ALMANYA', 'ANDORRA' => 'ANDORRA', 'ANGOLA' => 'ANGOLA', 'ANGUILLA' => 'ANGUILLA', 'ANTIGUA VE BARBUDA' => 'ANTIGUA VE BARBUDA', 'ARJANTIN' => 'ARJANTIN', 'ARNAVUTLUK' => 'ARNAVUTLUK', 'ARUBA' => 'ARUBA', 'AVUSTRALYA' => 'AVUSTRALYA', 'AVUSTURYA' => 'AVUSTURYA', 'AZERBAYCAN' => 'AZERBAYCAN', 'BAHAMALAR' => 'BAHAMALAR', 'BAHREYN' => 'BAHREYN', 'BANGLADES' => 'BANGLADES', 'BARBADOS' => 'BARBADOS', 'BELARUS' => 'BELARUS', 'BELCIKA' => 'BELCIKA', 'BELIZE' => 'BELIZE', 'BENIN' => 'BENIN', 'BERMUDA' => 'BERMUDA', 'BIRLESIK ARAP EMIRLIGI' => 'BIRLESIK ARAP EMIRLIGI', 'BOLIVYA' => 'BOLIVYA', 'BOSNA HERSEK' => 'BOSNA HERSEK', 'BOTSVANA' => 'BOTSVANA', 'BREZILYA' => 'BREZILYA', 'BRUNEI' => 'BRUNEI', 'BULGARISTAN' => 'BULGARISTAN', 'BURKINA FASO' => 'BURKINA FASO', 'BURMA (MYANMAR)' => 'BURMA (MYANMAR)', 'BURUNDI' => 'BURUNDI', 'BUTAN' => 'BUTAN', 'CAD' => 'CAD', 'CECENISTAN' => 'CECENISTAN', 'CEK CUMHURIYETI' => 'CEK CUMHURIYETI', 'CEZAYIR' => 'CEZAYIR', 'CIBUTI' => 'CIBUTI', 'CIN' => 'CIN', 'DANIMARKA' => 'DANIMARKA', 'DEMOKRATIK KONGO CUMHURIYETI' => 'DEMOKRATIK KONGO CUMHURIYETI', 'DOGU TIMOR' => 'DOGU TIMOR', 'DOMINIK' => 'DOMINIK', 'DOMINIK CUMHURIYETI' => 'DOMINIK CUMHURIYETI', 'EKVATOR' => 'EKVATOR', 'EKVATOR GINESI' => 'EKVATOR GINESI', 'EL SALVADOR' => 'EL SALVADOR', 'ENDONEZYA' => 'ENDONEZYA', 'ERITRE' => 'ERITRE', 'ERMENISTAN' => 'ERMENISTAN', 'ESTONYA' => 'ESTONYA', 'ETYOPYA' => 'ETYOPYA', 'FAS' => 'FAS', 'FIJI' => 'FIJI', 'FILDISI SAHILI' => 'FILDISI SAHILI', 'FILIPINLER' => 'FILIPINLER', 'FILISTIN' => 'FILISTIN', 'FINLANDIYA' => 'FINLANDIYA', 'FRANSA' => 'FRANSA', 'GABON' => 'GABON', 'GAMBIYA' => 'GAMBIYA', 'GANA' => 'GANA', 'GINE' => 'GINE', 'GRANADA' => 'GRANADA', 'GRONLAND' => 'GRONLAND', 'GUADELOPE' => 'GUADELOPE', 'GUAM ADASI' => 'GUAM ADASI', 'GUATEMALA' => 'GUATEMALA', 'GUNEY AFRIKA' => 'GUNEY AFRIKA', 'GUNEY KORE' => 'GUNEY KORE', 'GURCISTAN' => 'GURCISTAN', 'GUYANA' => 'GUYANA', 'HAITI' => 'HAITI', 'HINDISTAN' => 'HINDISTAN', 'HIRVATISTAN' => 'HIRVATISTAN', 'HOLLANDA' => 'HOLLANDA', 'HOLLANDA ANTILLERI' => 'HOLLANDA ANTILLERI', 'HONDURAS' => 'HONDURAS', 'HONG KONG' => 'HONG KONG', 'INGILTERE' => 'INGILTERE', 'IRAK' => 'IRAK', 'IRAN' => 'IRAN', 'IRLANDA' => 'IRLANDA', 'ISPANYA' => 'ISPANYA', 'ISRAIL' => 'ISRAIL', 'ISVEC' => 'ISVEC', 'ISVICRE' => 'ISVICRE', 'ITALYA' => 'ITALYA', 'IZLANDA' => 'IZLANDA', 'JAMAIKA' => 'JAMAIKA', 'JAPONYA' => 'JAPONYA', 'KAMBOCYA' => 'KAMBOCYA', 'KAMERUN' => 'KAMERUN', 'KANADA' => 'KANADA', 'KARADAG' => 'KARADAG', 'KATAR' => 'KATAR', 'KAZAKISTAN' => 'KAZAKISTAN', 'KENYA' => 'KENYA', 'KIRGIZISTAN' => 'KIRGIZISTAN', 'KIRGIZISTAN' => 'KIRGIZISTAN', 'KOLOMBIYA' => 'KOLOMBIYA', 'KOMORLAR' => 'KOMORLAR', 'KOSOVA' => 'KOSOVA', 'KOSTARIKA' => 'KOSTARIKA', 'KUBA' => 'KUBA', 'KUDUS' => 'KUDUS', 'KUVEYT' => 'KUVEYT', 'KUZEY KIBRIS' => 'KUZEY KIBRIS', 'KUZEY KORE' => 'KUZEY KORE', 'LAOS' => 'LAOS', 'LESOTO' => 'LESOTO', 'LETONYA' => 'LETONYA', 'LIBERYA' => 'LIBERYA', 'LIBYA' => 'LIBYA', 'LIECHTENSTEIN' => 'LIECHTENSTEIN', 'LITVANYA' => 'LITVANYA', 'LUBNAN' => 'LUBNAN', 'LUKSEMBURG' => 'LUKSEMBURG', 'MACARISTAN' => 'MACARISTAN', 'MADAGASKAR' => 'MADAGASKAR', 'MAKAO' => 'MAKAO', 'MAKEDONYA' => 'MAKEDONYA', 'MALAVI' => 'MALAVI', 'MALDIVLER' => 'MALDIVLER', 'MALEZYA' => 'MALEZYA', 'MALI' => 'MALI', 'MALTA' => 'MALTA', 'MARTINIK' => 'MARTINIK', 'MAURITIUS ADASI' => 'MAURITIUS ADASI', 'MAYOTTE' => 'MAYOTTE', 'MEKSIKA' => 'MEKSIKA', 'MIKRONEZYA' => 'MIKRONEZYA', 'MISIR' => 'MISIR', 'MOGOLISTAN' => 'MOGOLISTAN', 'MOLDAVYA' => 'MOLDAVYA', 'MONAKO' => 'MONAKO', 'MONTSERRAT (U.K.)' => 'MONTSERRAT (U.K.)', 'MORITANYA' => 'MORITANYA', 'MOZAMBIK' => 'MOZAMBIK', 'NAMBIYA' => 'NAMBIYA', 'NEPAL' => 'NEPAL', 'NIJER' => 'NIJER', 'NIJERYA' => 'NIJERYA', 'NIKARAGUA' => 'NIKARAGUA', 'NIUE' => 'NIUE', 'NORVEC' => 'NORVEC', 'ORTA AFRIKA CUMHURIYETI' => 'ORTA AFRIKA CUMHURIYETI', 'OZBEKISTAN' => 'OZBEKISTAN', 'PAKISTAN' => 'PAKISTAN', 'PALAU' => 'PALAU', 'PANAMA' => 'PANAMA', 'PAPUA YENI GINE' => 'PAPUA YENI GINE', 'PARAGUAY' => 'PARAGUAY', 'PERU' => 'PERU', 'PITCAIRN ADASI' => 'PITCAIRN ADASI', 'POLONYA' => 'POLONYA', 'PORTEKIZ' => 'PORTEKIZ', 'PORTO RIKO' => 'PORTO RIKO', 'REUNION' => 'REUNION', 'ROMANYA' => 'ROMANYA', 'RUANDA' => 'RUANDA', 'RUSYA' => 'RUSYA', 'SAMOA' => 'SAMOA', 'SENEGAL' => 'SENEGAL', 'SEYSEL ADALARI' => 'SEYSEL ADALARI', 'SILI' => 'SILI', 'SINGAPUR' => 'SINGAPUR', 'SIRBISTAN' => 'SIRBISTAN', 'SLOVAKYA' => 'SLOVAKYA', 'SLOVENYA' => 'SLOVENYA', 'SOMALI' => 'SOMALI', 'SRI LANKA' => 'SRI LANKA', 'SUDAN' => 'SUDAN', 'SURINAM' => 'SURINAM', 'SURIYE' => 'SURIYE', 'SUUDI ARABISTAN' => 'SUUDI ARABISTAN', 'SVALBARD' => 'SVALBARD', 'SVAZILAND' => 'SVAZILAND', 'TACIKISTAN' => 'TACIKISTAN', 'TANZANYA' => 'TANZANYA', 'TAYLAND' => 'TAYLAND', 'TAYVAN' => 'TAYVAN', 'TOGO' => 'TOGO', 'TONGA' => 'TONGA', 'TRINIDAT VE TOBAGO' => 'TRINIDAT VE TOBAGO', 'TUNUS' => 'TUNUS', 'TURKIYE' => 'TURKIYE', 'TURKMENISTAN' => 'TURKMENISTAN', 'UGANDA' => 'UGANDA', 'UKRAYNA' => 'UKRAYNA', 'UKRAYNA-KIRIM' => 'UKRAYNA-KIRIM', 'UMMAN' => 'UMMAN', 'URDUN' => 'URDUN', 'URUGUAY' => 'URUGUAY', 'VANUATU' => 'VANUATU', 'VATIKAN' => 'VATIKAN', 'VENEZUELA' => 'VENEZUELA', 'VIETNAM' => 'VIETNAM', 'YEMEN' => 'YEMEN', 'YENI KALEDONYA' => 'YENI KALEDONYA', 'YENI ZELLANDA' => 'YENI ZELLANDA', 'YESIL BURUN' => 'YESIL BURUN', 'YUNANISTAN' => 'YUNANISTAN', 'ZAMBIYA' => 'ZAMBIYA', 'ZIMBABVE' => 'ZIMBABVE');
	
	protected $hicriaylar = array(
		0 => '',
		1 => 'Muharrem',
		2 => 'Safer',
		3 => "Rebiü'l-Evvel",
		4 => "Rebiü'l-Ahir",
		5 => "Cemaziye'l-Evvel",
		6 => "Cemaziye'l-Ahir",
		7 => 'Recep',
		8 => 'Şaban',
		9 => 'Ramazan',
		10 => 'Sevval',
		11 => "Zi'l-ka'de",
		12 => "Zi'l-Hicce"
	);
		
	/**
     * Sınıfı yapılandırıcı fonksiyon
     *
     * @return mixed
     */
	public function __construct($cache_klasoru=NULL, $hicriaylar=NULL, $ulkeler=NULL)
	{
		// Cache yolunu belirleyelim!
		$dosyayolu = dirname(__FILE__);
		$this->cache = is_null( $cache_klasoru ) === TRUE ? $dosyayolu . DIRECTORY_SEPARATOR . $this->cache_klasoru . DIRECTORY_SEPARATOR : $cache_klasoru;
		if (!is_null($hicriaylar))
		{
			$this->hicriaylar = is_null($hicriaylar) ? $this->hicriaylar : $hicriaylar;
			$this->ulkeler = is_null($ulkeler) ? $this->ulkeler : $ulkeler;
		}
	}
	
		
	#####################################################################################################################
	#####											VERİ VERME İŞLEMLERİ											#####
	#####################################################################################################################
	
	/**
     * Ülkesi verilen şehirleri çeker
     *
     * @param string Verisi çekilecek ülkeyi belirler
	 * @param string Verinin dışarıya nasıl çıktılanacağını belirtir
     * @return array Sonucu bir dizi olarak döndürür
     */
	public function ulkeler( $cikti='array' )
	{
		$sonuc = $this->ulkeler;
		$yazdir = $cikti == 'array' ? $sonuc : json_encode( $sonuc );
		return $yazdir;
	}
	
	/**
     * Ülkesi verilen şehirleri çeker
     *
     * @param string Verisi çekilecek ülkeyi belirler
	 * @param string Verinin dışarıya nasıl çıktılanacağını belirtir
     * @return array Sonucu bir dizi olarak döndürür
     */
	public function sehirler( $ulke=NULL, $cikti='array' )
	{
		$ulke = is_null( $ulke ) === TRUE ? $this->ulke : $ulke;
		
		if ($this->__cache_sor( 'sehirler_' . $ulke ) )
		{
			$sonuc = $this->__cache_oku( 'sehirler_' . $ulke );
		} else {
			$veri = $this->al_sehirler( $ulke );
			if ( $veri['durum'] == 'basarili' )
			{
				$this->__cache_yaz( 'sehirler_' . $ulke, json_encode($veri) );
			}
			$sonuc = json_encode( $veri );
		}
		
		$yazdir = $cikti == 'json' ? $sonuc : json_decode( $sonuc, TRUE );
		return $yazdir;
	}
	
	/**
     * Şehri verilen ilçeleri çeker
     *
     * @param string Verisi çekilecek şehri belirler
	 * @param string Verinin dışarıya nasıl çıktılanacağını belirtir
     * @return array Sonucu bir dizi olarak döndürür
     */
	public function ilceler( $sehir=NULL, $cikti='array' )
	{
		$sehir = is_null( $sehir ) === TRUE ? $this->sehir : $sehir;
		
		if ( $this->__cache_sor( 'ilceler_' . $sehir ) )
		{
			$sonuc = $this->__cache_oku( 'ilceler_' . $sehir );
		} else {
			$veri = $this->al_ilceler( $sehir );
			
			if( $veri['durum'] == 'basarili' )
			{
				$this->__cache_yaz( 'ilceler_' . $sehir , json_encode($veri) );
			}
			$sonuc = json_encode( $veri );
		}
		
		$yazdir = $cikti == 'json' ? $sonuc : json_decode( $sonuc, TRUE );
		return $yazdir;
	}
	
	/**
     * Verilen ülke ve şehir için vakitleri çeker
     *
     * @param string Verisi çekilecek ülkeyi belirler
	 * @param string Verisi çekilecek şehiri belirler
	 * @param string Verinin dışarıya nasıl çıktılanacağını belirtir
     * @return array Sonucu bir dizi olarak döndürür
     */
	public function vakit( $sehir=NULL, $ulke=NULL, $cikti='array' )
	{
		$sehir = is_null( $sehir ) === TRUE ? $this->sehir : $sehir;
		$ulke = is_null( $ulke ) === TRUE ? $this->ulke : $ulke;
		
		if( $this->__cache_sor( 'vakit_' . $ulke . '_' . $sehir, 1 ) )
		{
			$sonuc = $this->__cache_oku( 'vakit_' . $ulke . '_' . $sehir );
		} else {
			$veri = $this->al_vakitler( $sehir, $ulke );
			
			if( $veri['durum'] == 'basarili' )
			{
				$this->__cache_yaz( 'vakit_' . $ulke . '_' . $sehir , json_encode($veri) );
			}
			$sonuc = json_encode( $veri );
		}
		$yazdir = $cikti == 'json' ? $sonuc : json_decode( $sonuc, TRUE );
		return $yazdir;
	}
	
	
	#####################################################################################################################
	#####												CACHE İŞLEMLERİ												#####
	#####################################################################################################################
	
	/**
     * Cache dosyası var mı yok mu, varsa süresi geçerli mi onu kontrol eder!
     *
     * @param string Dosyanın adı
	 * @param integer 0 - süresiz, 1 - 1 gün süreli
     * @return boolean Sonuç TRUE ya da FALSE olarak döner.
     */
	private function __cache_sor( $dosya, $gecerli=0 )
	{
		if ( file_exists( $this->cache .  $dosya . '.json' ) AND is_readable( $this->cache . $dosya . '.json' ) )
		{
			if ( $gecerli == 0 )
			{
				return TRUE;
			} else {
				$dosya_zamani = date( 'dmY', filemtime( $this->cache . $dosya . '.json' ) );
				$bugun = date( 'dmY', time() );
				
				if ( $dosya_zamani == $bugun )
				{
					return TRUE;
				} else {
					return FALSE;
				}
			}
		} else {
			return FALSE;
		}
	}
	
	/**
     * Cache dosyasından okur
     *
     * @param string Dosyanın adı
     * @return json Sonuç json türünde geri döner
     */
	private function __cache_oku( $dosya )
	{
		return file_get_contents( $this->cache . $dosya . '.json' );
	}
	
	/**
     * Cache dosyasına yazar
     *
     * @param string Dosyanın adı
	 * @param string Dosyaya kaydedilecek veri
     * @return mixed Sonuç dönmez
     */
	private function __cache_yaz( $dosya , $veri )
	{
		$fp = fopen( $this->cache . $dosya . '.json', "w" );
		fwrite( $fp, $veri );
		fclose( $fp );
		return;
	}
	
		
	
	#####################################################################################################################
	#####											VERİ ÇEKME İŞLEMLERİ											#####
	#####################################################################################################################
	
	/**
     * Ülkesi verilen şehirleri çeker
     *
     * @param string Verisi çekilecek ülkeyi belirler
     * @return array Sonucu bir dizi olarak döndürür
     */
	private function al_sehirler( $ulke )
	{
		$url = $ulke == 'TURKIYE' ? 'http://www.diyanet.gov.tr/PrayerTime/FillCity?itemId=%s&isState=false&isTurkey=true&itemSource=inner' : 'http://www.diyanet.gov.tr/PrayerTime/FillCity?itemId=%s&isState=false&isTurkey=false&itemSource=inner';
		
		$sonuc = $this->__curl( $url, urlencode($ulke) );
		
		if( $sonuc['durum'] == 'basarili' )
		{
			$veri = array();
			foreach( $sonuc['veri'] as $v )
			{
				$veri[] = array(
					'text'	=> $v['Text'],
					'value'	=> $v['Value'],
				);
			}
			
			$sonuc['veri'] = $veri;
		}
				
		return $sonuc;
	}
	
	
	/**
     * Şehri verilen ilçeleri çeker
     *
     * @param string Verisi çekilecek şehri belirler
     * @return array Sonucu bir dizi olarak döndürür
     */
	private function al_ilceler( $sehir )
	{
		$url = 'http://www.diyanet.gov.tr/PrayerTime/FillDistrict?itemId=%s';
		
		$sonuc = $this->__curl( $url, urlencode($sehir) );
		
		if( $sonuc['durum'] == 'basarili' )
		{
			$veri = array();
			foreach( $sonuc['veri'] as $v )
			{
				$text = $v['Text'] == $sehir ? $v['Text'] . ' - MERKEZ' : $v['Text'];
				$veri[] = array(
					'text'	=> $text,
					'value'	=> $v['Value'],
				);
			}
			
			$sonuc['veri'] = $veri;
		}
				
		return $sonuc;
	}
	
	
	/**
     * Verilen ülke ve şehir için vakitleri çeker
     *
     * @param string Verisi çekilecek ülkeyi belirler
	 * @param string Verisi çekilecek şehiri belirler
     * @return array Sonucu bir dizi olarak döndürür
     */
	private function al_vakitler( $sehir=NULL, $ulke=NULL )
	{
		$ulke = is_null( $ulke ) === TRUE ? $this->ulke : $ulke;
		$sehir = is_null( $sehir ) === TRUE ? $this->ilce : $sehir;
		
		$url = 'http://www.diyanet.gov.tr/PrayerTime/PrayerTimesSet';
		
		$data = array(
			"countryName"	=> "$ulke",
			"name"			=> "$sehir",
			"itemSource"	=> "inner"
		);
		
		$data = json_encode( $data );
		
		$sonuc = $this->__curl( $url, $data, TRUE );
		
		$karaliste = array('NextImsak', 'GunesText', 'ImsakText', 'OgleText', 'IkindiText', 'AksamText', 'YatsiText', 'HolyDaysItem');
		
		if ( $sonuc['durum'] == 'basarili' )
		{
			$veri = array();
			foreach ( $sonuc['veri'] as $k=>$v )
			{
				if( !in_array($k, $karaliste ) )
				{
					if ( $k == 'MoonSrc' )
					{
						$veri[strtolower($k)] = 'http://www.diyanet.gov.tr' . $v;
					}
					elseif ( $k == 'HicriTarih' )
					{
						$veri[strtolower($k)] = $this->hicri();
					} else {
						$veri[strtolower($k)] = $v;
					}
				}
			}
			$sonuc['veri'] = $veri;
		}
		
		return $sonuc;
	}
		
	
	/**
     * Diyanetten verileri almak için cURL metodu - Özeldir
     *
     * @param string Bağlantı adresini verir
     * @param string Başlantı için gerekli verileri verir
	 * @param boolean Bu bağlantının POST metodu ile yapılıp yapılmayacağını belirtir
     * @return array sonucu bir dizi olarak döndürür
     */
	private function __curl($url, $data, $is_post=FALSE)
	{
		if( !$is_post )
		{
			$url = sprintf( $url, $data );
		}
		
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		
		// Post varsa 
		if ( $is_post )
		{
			curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'Content-Length: ' . strlen( $data ) ) );
		}
			
		curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:26.0) Gecko/20100101 Firefox/26.0' );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		
		$bilgi = curl_getinfo( $ch );
		$veri = curl_exec( $ch );
				
		if( $bilgi['http_code'] == 200 ) // POST durumunda geçerli veri dönerse HTTP_RESPONSE_CODE = 200 oluyor!
		{
			
			$sonuc = array(
				'durum'	=> 'basarili',
				'veri'	=> json_decode( $veri, TRUE )
			);
		} else {
			// GET Durumunda HTTP_RESPONSE_CODE = 0 olduğundan gelen veriye bakıyoruz. Eğer [] ise hata, değil ise veri!
			if( $veri != '[]' )
			{
				$sonuc = array(
					'durum'	=> 'basarili',
					'veri'	=> json_decode( $veri, TRUE )
				);
			} else {
				$sonuc = array(
					'durum'	=> 'hata',
					'veri'	=> array()
				);
			}
		}
		curl_close( $ch );
		return $sonuc;
	}
	
	
	#####################################################################################################################
	#####										HİCRİ TAKVIM FONKSIYONLARI											#####
	#####################################################################################################################
	
	private function hicri($tarih = null)
	{
		if ($tarih === null) $tarih = date('d.m.Y',time());
		$t = explode('.',$tarih);
		
		return $this->jd2hicri(cal_to_jd(CAL_GREGORIAN, $t[1],$t[0],$t[2]));
	}
	
	private function miladi($tarih = null)
	{
		if ($tarih === null) $tarih = date('d.m.Y',time());
		$t = explode('.',$tarih);
		return jd_to_cal(CAL_GREGORIAN,$this->hicri2jd($t[1],$t[0],$t[2]));
	}

    # julian day takviminden hicriye geçiş
    private function jd2hicri($jd)
    {
        $jd = $jd - 1948440 + 10632;
        $n  = (int)(($jd - 1) / 10631);
        $jd = $jd - 10631 * $n + 354;
        $j  = ((int)((10985 - $jd) / 5316)) *
            ((int)(50 * $jd / 17719)) +
            ((int)($jd / 5670)) *
            ((int)(43 * $jd / 15238));
        $jd = $jd - ((int)((30 - $j) / 15)) *
            ((int)((17719 * $j) / 50)) -
            ((int)($j / 16)) *
            ((int)((15238 * $j) / 43)) + 29;
        $m  = (int)(24 * $jd / 709);
        $d  = $jd - (int)(709 * $m / 24);
        $y  = 30*$n + $j - 30;

        return $d . ' ' . $this->hicriaylar[$m] . ' ' . $y;
    }

    # hicriden julian day takvimine geçiş
    private function hicri2jd($m, $d, $y)
    {
        return (int)((11 * $y + 3) / 30) +
            354 * $y + 30 * $m -
            (int)(($m - 1) / 2) + $d + 1948440 - 385;
    }
	
} // Sınıf Bitti