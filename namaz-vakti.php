<?php
/*
Plugin Name: Namaz-Ezan Vakitleri
Plugin URI: http://www.erdemarslan.com/wordpress/18-12-2013/535-namaz-vakitleri-wordpress-eklentisi-widget.html
Description: Bu eklenti Diyanet İşleri Başkanlığından namaz vakitlerini alır ve gösterir. This plugin get prayer times from Presidency of Religious Affairs of Turkey and show in pretty widget/shortcode.
Version: 2.0.3
Author: Erdem ARSLAN
Author URI: http://www.erdemarslan.com
*/


$plugin		= plugin_basename(__FILE__);
$plugindir	= dirname(__FILE__) . DIRECTORY_SEPARATOR;

// Tanımlamaları yap
# Eklenti tanımlamaları
define( 'NV_NAME', $plugin );
define( 'NV_VERSION', '2.0.3' );
define( 'NV_PLUGIN_DIR', $plugindir );

# Veritabanı tanımlamaları
define( 'NV_DB_WIDGET_COLORSET', 'namazvakti_widget_rengi' );
define( 'NV_DB_DEFAULT_COUNTRY_NAME', 'namazvakti_varsayilan_ulke' );
define( 'NV_DB_DEFAULT_CITY_NAME', 'namazvakti_varsayilan_sehir' );
define( 'NV_DB_DEFAULT_TOWN_NAME', 'namazvakti_varsayilan_ilce' );

// Gerekli Dosyaları Çek
require_once 'include/class.wp-less.php';
require_once 'include/class.namazvakti.php';
require_once 'include/widget.namazvakti.php';

$hicriaylar = array(
	0 => '',
	1 => __('Muharrem', 'namazvakti'),
	2 => __('Safer', 'namazvakti'),
	3 => __("Rebiü'l-Evvel", 'namazvakti'),
	4 => __("Rebiü'l-Ahir", 'namazvakti'),
	5 => __("Cemaziye'l-Evvel", 'namazvakti'),
	6 => __("Cemaziye'l-Ahir", 'namazvakti'),
	7 => __('Recep', 'namazvakti'),
	8 => __('Şaban', 'namazvakti'),
	9 => __('Ramazan', 'namazvakti'),
	10 => __('Sevval', 'namazvakti'),
	11 => __("Zi'l-ka'de", 'namazvakti'),
	12 => __("Zi'l-Hicce", 'namazvakti')
);

// Namazvakti sınıfı için ülkelerin dil dosyası için ayarlanmış hali!
$diyanetten_cekilen_ulkeler = array('ABD' => __('ABD', 'namazvakti'), 'AFGANISTAN' => __('AFGANISTAN', 'namazvakti'), 'ALMANYA' => __('ALMANYA', 'namazvakti'), 'ANDORRA' => __('ANDORRA', 'namazvakti'), 'ANGOLA' => __('ANGOLA', 'namazvakti'), 'ANGUILLA' => __('ANGUILLA', 'namazvakti'), 'ANTIGUA VE BARBUDA' => __('ANTIGUA VE BARBUDA', 'namazvakti'), 'ARJANTIN' => __('ARJANTIN', 'namazvakti'), 'ARNAVUTLUK' => __('ARNAVUTLUK', 'namazvakti'), 'ARUBA' => __('ARUBA', 'namazvakti'), 'AVUSTRALYA' => __('AVUSTRALYA', 'namazvakti'), 'AVUSTURYA' => __('AVUSTURYA', 'namazvakti'), 'AZERBAYCAN' => __('AZERBAYCAN', 'namazvakti'), 'BAHAMALAR' => __('BAHAMALAR', 'namazvakti'), 'BAHREYN' => __('BAHREYN', 'namazvakti'), 'BANGLADES' => __('BANGLADES', 'namazvakti'), 'BARBADOS' => __('BARBADOS', 'namazvakti'), 'BELARUS' => __('BELARUS', 'namazvakti'), 'BELCIKA' => __('BELCIKA', 'namazvakti'), 'BELIZE' => __('BELIZE', 'namazvakti'), 'BENIN' => __('BENIN', 'namazvakti'), 'BERMUDA' => __('BERMUDA', 'namazvakti'), 'BIRLESIK ARAP EMIRLIGI' => __('BIRLESIK ARAP EMIRLIGI', 'namazvakti'), 'BOLIVYA' => __('BOLIVYA', 'namazvakti'), 'BOSNA HERSEK' => __('BOSNA HERSEK', 'namazvakti'), 'BOTSVANA' => __('BOTSVANA', 'namazvakti'), 'BREZILYA' => __('BREZILYA', 'namazvakti'), 'BRUNEI' => __('BRUNEI', 'namazvakti'), 'BULGARISTAN' => __('BULGARISTAN', 'namazvakti'), 'BURKINA FASO' => __('BURKINA FASO', 'namazvakti'), 'BURMA (MYANMAR)' => __('BURMA (MYANMAR)', 'namazvakti'), 'BURUNDI' => __('BURUNDI', 'namazvakti'), 'BUTAN' => __('BUTAN', 'namazvakti'), 'CAD' => __('CAD', 'namazvakti'), 'CECENISTAN' => __('CECENISTAN', 'namazvakti'), 'CEK CUMHURIYETI' => __('CEK CUMHURIYETI', 'namazvakti'), 'CEZAYIR' => __('CEZAYIR', 'namazvakti'), 'CIBUTI' => __('CIBUTI', 'namazvakti'), 'CIN' => __('CIN', 'namazvakti'), 'DANIMARKA' => __('DANIMARKA', 'namazvakti'), 'DEMOKRATIK KONGO CUMHURIYETI' => __('DEMOKRATIK KONGO CUMHURIYETI', 'namazvakti'), 'DOGU TIMOR' => __('DOGU TIMOR', 'namazvakti'), 'DOMINIK' => __('DOMINIK', 'namazvakti'), 'DOMINIK CUMHURIYETI' => __('DOMINIK CUMHURIYETI', 'namazvakti'), 'EKVATOR' => __('EKVATOR', 'namazvakti'), 'EKVATOR GINESI' => __('EKVATOR GINESI', 'namazvakti'), 'EL SALVADOR' => __('EL SALVADOR', 'namazvakti'), 'ENDONEZYA' => __('ENDONEZYA', 'namazvakti'), 'ERITRE' => __('ERITRE', 'namazvakti'), 'ERMENISTAN' => __('ERMENISTAN', 'namazvakti'), 'ESTONYA' => __('ESTONYA', 'namazvakti'), 'ETYOPYA' => __('ETYOPYA', 'namazvakti'), 'FAS' => __('FAS', 'namazvakti'), 'FIJI' => __('FIJI', 'namazvakti'), 'FILDISI SAHILI' => __('FILDISI SAHILI', 'namazvakti'), 'FILIPINLER' => __('FILIPINLER', 'namazvakti'), 'FILISTIN' => __('FILISTIN', 'namazvakti'), 'FINLANDIYA' => __('FINLANDIYA', 'namazvakti'), 'FRANSA' => __('FRANSA', 'namazvakti'), 'GABON' => __('GABON', 'namazvakti'), 'GAMBIYA' => __('GAMBIYA', 'namazvakti'), 'GANA' => __('GANA', 'namazvakti'), 'GINE' => __('GINE', 'namazvakti'), 'GRANADA' => __('GRANADA', 'namazvakti'), 'GRONLAND' => __('GRONLAND', 'namazvakti'), 'GUADELOPE' => __('GUADELOPE', 'namazvakti'), 'GUAM ADASI' => __('GUAM ADASI', 'namazvakti'), 'GUATEMALA' => __('GUATEMALA', 'namazvakti'), 'GUNEY AFRIKA' => __('GUNEY AFRIKA', 'namazvakti'), 'GUNEY KORE' => __('GUNEY KORE', 'namazvakti'), 'GURCISTAN' => __('GURCISTAN', 'namazvakti'), 'GUYANA' => __('GUYANA', 'namazvakti'), 'HAITI' => __('HAITI', 'namazvakti'), 'HINDISTAN' => __('HINDISTAN', 'namazvakti'), 'HIRVATISTAN' => __('HIRVATISTAN', 'namazvakti'), 'HOLLANDA' => __('HOLLANDA', 'namazvakti'), 'HOLLANDA ANTILLERI' => __('HOLLANDA ANTILLERI', 'namazvakti'), 'HONDURAS' => __('HONDURAS', 'namazvakti'), 'HONG KONG' => __('HONG KONG', 'namazvakti'), 'INGILTERE' => __('INGILTERE', 'namazvakti'), 'IRAK' => __('IRAK', 'namazvakti'), 'IRAN' => __('IRAN', 'namazvakti'), 'IRLANDA' => __('IRLANDA', 'namazvakti'), 'ISPANYA' => __('ISPANYA', 'namazvakti'), 'ISRAIL' => __('ISRAIL', 'namazvakti'), 'ISVEC' => __('ISVEC', 'namazvakti'), 'ISVICRE' => __('ISVICRE', 'namazvakti'), 'ITALYA' => __('ITALYA', 'namazvakti'), 'IZLANDA' => __('IZLANDA', 'namazvakti'), 'JAMAIKA' => __('JAMAIKA', 'namazvakti'), 'JAPONYA' => __('JAPONYA', 'namazvakti'), 'KAMBOCYA' => __('KAMBOCYA', 'namazvakti'), 'KAMERUN' => __('KAMERUN', 'namazvakti'), 'KANADA' => __('KANADA', 'namazvakti'), 'KARADAG' => __('KARADAG', 'namazvakti'), 'KATAR' => __('KATAR', 'namazvakti'), 'KAZAKISTAN' => __('KAZAKISTAN', 'namazvakti'), 'KENYA' => __('KENYA', 'namazvakti'), 'KIRGIZISTAN' => __('KIRGIZISTAN', 'namazvakti'), 'KIRGIZISTAN' => __('KIRGIZISTAN', 'namazvakti'), 'KOLOMBIYA' => __('KOLOMBIYA', 'namazvakti'), 'KOMORLAR' => __('KOMORLAR', 'namazvakti'), 'KOSOVA' => __('KOSOVA', 'namazvakti'), 'KOSTARIKA' => __('KOSTARIKA', 'namazvakti'), 'KUBA' => __('KUBA', 'namazvakti'), 'KUDUS' => __('KUDUS', 'namazvakti'), 'KUVEYT' => __('KUVEYT', 'namazvakti'), 'KUZEY KIBRIS' => __('KUZEY KIBRIS', 'namazvakti'), 'KUZEY KORE' => __('KUZEY KORE', 'namazvakti'), 'LAOS' => __('LAOS', 'namazvakti'), 'LESOTO' => __('LESOTO', 'namazvakti'), 'LETONYA' => __('LETONYA', 'namazvakti'), 'LIBERYA' => __('LIBERYA', 'namazvakti'), 'LIBYA' => __('LIBYA', 'namazvakti'), 'LIECHTENSTEIN' => __('LIECHTENSTEIN', 'namazvakti'), 'LITVANYA' => __('LITVANYA', 'namazvakti'), 'LUBNAN' => __('LUBNAN', 'namazvakti'), 'LUKSEMBURG' => __('LUKSEMBURG', 'namazvakti'), 'MACARISTAN' => __('MACARISTAN', 'namazvakti'), 'MADAGASKAR' => __('MADAGASKAR', 'namazvakti'), 'MAKAO' => __('MAKAO', 'namazvakti'), 'MAKEDONYA' => __('MAKEDONYA', 'namazvakti'), 'MALAVI' => __('MALAVI', 'namazvakti'), 'MALDIVLER' => __('MALDIVLER', 'namazvakti'), 'MALEZYA' => __('MALEZYA', 'namazvakti'), 'MALI' => __('MALI', 'namazvakti'), 'MALTA' => __('MALTA', 'namazvakti'), 'MARTINIK' => __('MARTINIK', 'namazvakti'), 'MAURITIUS ADASI' => __('MAURITIUS ADASI', 'namazvakti'), 'MAYOTTE' => __('MAYOTTE', 'namazvakti'), 'MEKSIKA' => __('MEKSIKA', 'namazvakti'), 'MIKRONEZYA' => __('MIKRONEZYA', 'namazvakti'), 'MISIR' => __('MISIR', 'namazvakti'), 'MOGOLISTAN' => __('MOGOLISTAN', 'namazvakti'), 'MOLDAVYA' => __('MOLDAVYA', 'namazvakti'), 'MONAKO' => __('MONAKO', 'namazvakti'), 'MONTSERRAT (U.K.)' => __('MONTSERRAT (U.K.)', 'namazvakti'), 'MORITANYA' => __('MORITANYA', 'namazvakti'), 'MOZAMBIK' => __('MOZAMBIK', 'namazvakti'), 'NAMBIYA' => __('NAMBIYA', 'namazvakti'), 'NEPAL' => __('NEPAL', 'namazvakti'), 'NIJER' => __('NIJER', 'namazvakti'), 'NIJERYA' => __('NIJERYA', 'namazvakti'), 'NIKARAGUA' => __('NIKARAGUA', 'namazvakti'), 'NIUE' => __('NIUE', 'namazvakti'), 'NORVEC' => __('NORVEC', 'namazvakti'), 'ORTA AFRIKA CUMHURIYETI' => __('ORTA AFRIKA CUMHURIYETI', 'namazvakti'), 'OZBEKISTAN' => __('OZBEKISTAN', 'namazvakti'), 'PAKISTAN' => __('PAKISTAN', 'namazvakti'), 'PALAU' => __('PALAU', 'namazvakti'), 'PANAMA' => __('PANAMA', 'namazvakti'), 'PAPUA YENI GINE' => __('PAPUA YENI GINE', 'namazvakti'), 'PARAGUAY' => __('PARAGUAY', 'namazvakti'), 'PERU' => __('PERU', 'namazvakti'), 'PITCAIRN ADASI' => __('PITCAIRN ADASI', 'namazvakti'), 'POLONYA' => __('POLONYA', 'namazvakti'), 'PORTEKIZ' => __('PORTEKIZ', 'namazvakti'), 'PORTO RIKO' => __('PORTO RIKO', 'namazvakti'), 'REUNION' => __('REUNION', 'namazvakti'), 'ROMANYA' => __('ROMANYA', 'namazvakti'), 'RUANDA' => __('RUANDA', 'namazvakti'), 'RUSYA' => __('RUSYA', 'namazvakti'), 'SAMOA' => __('SAMOA', 'namazvakti'), 'SENEGAL' => __('SENEGAL', 'namazvakti'), 'SEYSEL ADALARI' => __('SEYSEL ADALARI', 'namazvakti'), 'SILI' => __('SILI', 'namazvakti'), 'SINGAPUR' => __('SINGAPUR', 'namazvakti'), 'SIRBISTAN' => __('SIRBISTAN', 'namazvakti'), 'SLOVAKYA' => __('SLOVAKYA', 'namazvakti'), 'SLOVENYA' => __('SLOVENYA', 'namazvakti'), 'SOMALI' => __('SOMALI', 'namazvakti'), 'SRI LANKA' => __('SRI LANKA', 'namazvakti'), 'SUDAN' => __('SUDAN', 'namazvakti'), 'SURINAM' => __('SURINAM', 'namazvakti'), 'SURIYE' => __('SURIYE', 'namazvakti'), 'SUUDI ARABISTAN' => __('SUUDI ARABISTAN', 'namazvakti'), 'SVALBARD' => __('SVALBARD', 'namazvakti'), 'SVAZILAND' => __('SVAZILAND', 'namazvakti'), 'TACIKISTAN' => __('TACIKISTAN', 'namazvakti'), 'TANZANYA' => __('TANZANYA', 'namazvakti'), 'TAYLAND' => __('TAYLAND', 'namazvakti'), 'TAYVAN' => __('TAYVAN', 'namazvakti'), 'TOGO' => __('TOGO', 'namazvakti'), 'TONGA' => __('TONGA', 'namazvakti'), 'TRINIDAT VE TOBAGO' => __('TRINIDAT VE TOBAGO', 'namazvakti'), 'TUNUS' => __('TUNUS', 'namazvakti'), 'TURKIYE' => __('TURKIYE', 'namazvakti'), 'TURKMENISTAN' => __('TURKMENISTAN', 'namazvakti'), 'UGANDA' => __('UGANDA', 'namazvakti'), 'UKRAYNA' => __('UKRAYNA', 'namazvakti'), 'UKRAYNA-KIRIM' => __('UKRAYNA-KIRIM', 'namazvakti'), 'UMMAN' => __('UMMAN', 'namazvakti'), 'URDUN' => __('URDUN', 'namazvakti'), 'URUGUAY' => __('URUGUAY', 'namazvakti'), 'VANUATU' => __('VANUATU', 'namazvakti'), 'VATIKAN' => __('VATIKAN', 'namazvakti'), 'VENEZUELA' => __('VENEZUELA', 'namazvakti'), 'VIETNAM' => __('VIETNAM', 'namazvakti'), 'YEMEN' => __('YEMEN', 'namazvakti'), 'YENI KALEDONYA' => __('YENI KALEDONYA', 'namazvakti'), 'YENI ZELLANDA' => __('YENI ZELLANDA', 'namazvakti'), 'YESIL BURUN' => __('YESIL BURUN', 'namazvakti'), 'YUNANISTAN' => __('YUNANISTAN', 'namazvakti'), 'ZAMBIYA' => __('ZAMBIYA', 'namazvakti'), 'ZIMBABVE' => __('ZIMBABVE', 'namazvakti'));

// Namaz Sınıfını Başlat!
$nv = new Namaz( NV_PLUGIN_DIR . 'cache' . DIRECTORY_SEPARATOR, $hicriaylar, $diyanetten_cekilen_ulkeler );

Class WP_Namazvakti
{
	// Sınıf Değişkenleri
	private $nv;
	
	/*
		Yapılandırıcı Fonksiyon
	*/
	public function __construct()
	{
		// Eklenti aktifleştirilirken yapılması gerekenler!
		add_action( 'plugins_loaded', array( $this, 'update_namazvakti_plugin' ) );
		
		global $nv;
		// Diyanetten verileri çekecek ana sınıfımızı yüklüyoruz. Cache klasörünü de ayrıca belirtiyoruz.
		$this->nv = $nv; 
		
		// Eklentiyi Başlat
		add_action( 'init', array( $this, '__namazvakti_init' ) );
				
		// Widgetler için Shortcode desteği ekleyelim
		add_filter( 'widget_text', 'do_shortcode' );
		
		// Widgetleri Aktifleştir
		add_action( 'widgets_init', array( $this, '__widget_init' ) );
		
		// Admin menüsü ekle - Ayarların Altına
		add_action( 'admin_menu', array( $this, '_namazvakti_admin_menu_init' ) );
		
		// Eklentiye extra linkler ekle
		add_filter('plugin_action_links', array( $this, '__namazvakti_plugin_linkleri' ), 10, 2);
						
		// Ajax işlemlerini ekle
		add_action( 'wp_ajax_ajax_action', array( &$this, 'namazvakti_ajax' ) ); // ajax for logged in users
		add_action( 'wp_ajax_nopriv_ajax_action', array( &$this, 'namazvakti_ajax' ) ); // ajax for not logged in users
	}
	
	/*
		Eklentiyi Başlat
	*/
	public function __namazvakti_init()
	{
		// Sessionları aç!
		if(!session_id())session_start();
		
		
		// Dil dosyasını ekle
		load_plugin_textdomain('namazvakti', FALSE, dirname( NV_NAME ).'/languages/');
		load_plugin_textdomain('envator', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
		
		// Veritabanından çek ve renkleri ayarla! PHP Version >= PHP 5.3 olmalı
		add_filter( 'less_vars', function( $vars, $handle ){
			$color = explode( '|', get_option( NV_DB_WIDGET_COLORSET ) );
			$vars[ 'bg_location' ]	= $color[0];
			$vars[ 'bg_time' ]		= $color[1];
			$vars[ 'cl_active' ]	= $color[2];
			$vars[ 'bg_times' ]		= $color[3];
			$vars[ 'bg_active' ]	= $color[4];
			return $vars;
		}, 10, 2 );
		
		
		
		// Still ve JS dosyalarını ayarla
		wp_enqueue_script( 'jquery'); // javascript kütüphanesi
		
		if( !is_admin() )
		{
			wp_enqueue_style( 'era_nv_user_style', plugins_url( "/assets/main-style.less", __FILE__ ), array(), NV_VERSION ); // ana still dosyası
			wp_enqueue_script( 'era-countdown-plugin', plugins_url( "/assets/js/jquery.countdown.js", __FILE__), array( 'jquery' ), NV_VERSION ); // sayaç dosyası
			wp_enqueue_script( 'era-ajax-request', plugins_url( "/assets/js/namazvakti.js", __FILE__), array( 'jquery' ), NV_VERSION ); // eklenti ile ilgili js dosyası
			wp_localize_script( 'era-ajax-request', 'eranvjs', array(
				'ajaxurl'	=> admin_url( 'admin-ajax.php' ),
				// bundan sonrası javascript dosyalarında dil ayarları için
				'imsak'	=> __("İmsak'a kalan zaman", 'namazvakti'),
				'gunes'	=> __("Güneş'e kalan zaman", 'namazvakti'),
				'ogle'	=> __("Öğle'ne kalan zaman",'namazvakti'),
				'ikindi' => __("İkindi'ye kalan zaman", 'namazvakti'),
				'aksam'	=> __("Akşam'a kalan zaman", 'namazvakti'),
				'yatsi'	=> __("Yatsı'ya kalan zaman", 'namazvakti'),
				'sehir_sec'	=> __('Lütfen bir şehir seçiniz', 'namazvakti'),
				'ilce_sec'	=> __('Lütfen bir ilçe seçiniz', 'namazvakti'),
				'ulke_secilmemis' => __('Vakitleri çekebilmek için öncelikle ülke seçmelisiniz!', 'namazvakti'),
				'sehir_secilmemis' => __('Vakitleri çekebilmek için öncelikle şehir seçmelisiniz!', 'namazvakti'),
				'ilce_secilmemis'	=> __('Vakitleri çekebilmek için öncelikle ilçe seçmelisiniz!', 'namazvakti'),
				'hata_veri_cekilemedi'	=> __('Sunucudan veri çekilemedi!', 'namazvakti')
			)); // ajax işlemleri için bilgi ve js dosyalarının yerelleştirilmesi için gerekli
			
			
			
		} else {
			wp_localize_script( 'era-ajax-request', 'EraAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php') ) ); // admin için
			wp_enqueue_script( 'era-ajax-request', plugins_url( "/assets/js/namazvakti-admin.js", __FILE__), array( 'jquery' ), NV_VERSION ); // admin namazvakti js eklentisi
			
		}
	}
	
	/*
		Eski güncellemelere ait veritabanı bilgilerini uçurur! Yenilerini yerine koyar!
	*/
	public function update_namazvakti_plugin()
	{
		if( get_option( 'namazvakti_version' ) != NV_VERSION )
		{
			$old_db_names = array(
				'namazvakti_sehirler',
				'namazvakti_varsayilan_sehir',
				'namazvakti_api_anahtari',
				'namazvakti_sehir_ID',
				'namazvakti_sehir_adi',
				'namazvakti_widget_rengi'
			);
			// Eski veritabanı bilgilerini sil!
			foreach ($old_db_names as $db_name)
			{
				delete_option($db_name);
			}
			
			update_option( 'namazvakti_version', NV_VERSION );
			
			// Yenilerini oluştur ve varsayılan değerlerini ata!
			if ( get_option( NV_DB_WIDGET_COLORSET ) === FALSE )
			{
				add_option ( NV_DB_WIDGET_COLORSET, '#C4364C|#F04862|#F04862|#364363|#50587C' );
			}
			
			if ( get_option( NV_DB_DEFAULT_COUNTRY_NAME ) === FALSE )
			{
				add_option ( NV_DB_DEFAULT_COUNTRY_NAME, 'TURKIYE' );
			}
			
			if ( get_option( NV_DB_DEFAULT_CITY_NAME ) === FALSE )
			{
				add_option ( NV_DB_DEFAULT_CITY_NAME, 'ISTANBUL' );
			}
			
			if ( get_option( NV_DB_DEFAULT_TOWN_NAME ) === FALSE )
			{
				add_option ( NV_DB_DEFAULT_TOWN_NAME, 'ISTANBUL' );
			}
		}
	}
	
	/*
		Ajax ile gelen sorguları yap ve geri döndür!
	*/
	public function namazvakti_ajax()
	{
		switch($_POST['do'])
		{
			case 'getCities':
				$sehirler = $this->nv->sehirler($_POST['country'], 'json');
				echo $sehirler;
				die();
			break;
			
			case 'getLocations':
				$ilceler = $this->nv->ilceler($_POST['city'], 'json');
				echo $ilceler;
				die();
			break;
			
			case 'getTimes':
			
				// sessionları buraya ekle!
				$_SESSION[NV_DB_DEFAULT_COUNTRY_NAME] = $_POST['country'];
				$_SESSION[NV_DB_DEFAULT_CITY_NAME] = $_POST['town'];
				$_SESSION[NV_DB_DEFAULT_TOWN_NAME] = $_POST['city'];
			
				$vakit = $this->nv->vakit($_POST['city'],$_POST['country'], 'json');
				echo $vakit;
				die();
			break;
		}
	}

	
	/*
		namazvakti admin menü init - admin menüsünü ayarlar
	*/
	public function _namazvakti_admin_menu_init()
	{
		add_options_page( __( 'Namaz Vakti Ayarları', 'namazvakti' ), __( 'Namaz Vakti Ayarları', 'namazvakti' ), 'manage_options', 'namazvakti', array( $this, '__namazvakti_ayar_sayfalari' ) );
	}
	
	/*
		Plugin sayfasındaki eklentimize yeni linkler ekleyelim
	*/
	public function __namazvakti_plugin_linkleri( $linkler, $dosya )
	{
		if( NV_NAME == $dosya )
		{
			$settings	= sprintf( '<a href="%s"> %s </a>', admin_url( 'options-general.php?page=namazvakti' ), __( 'Ayarlar', 'namazvakti' ) );
			$colors		= sprintf( '<a href="%s"> %s </a>', admin_url( 'options-general.php?page=namazvakti&tab=style' ), __( 'Renk Ayarları', 'namazvakti' ) );
			array_unshift( $linkler, $colors );
			array_unshift( $linkler, $settings);
		}
		return $linkler;
	}
	
	/*
		namazvakti option sayfaları!
	*/
	
	public function __namazvakti_ayar_sayfalari()
	{
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __('Bu sayfaya erişim izniniz bulunmuyor.', 'namazvakti') );
		}
		?>
        <h2><?php _e('Wordpress için Namaz Vakitleri', 'namazvakti'); ?></h2>
        <?php
		
		// Tablar
		$default_tabs = array(
			'general'	=> __( 'Genel Ayarlar', 'namazvakti' ),
			'style'		=> __( 'Renk Ayarları', 'namazvakti' ),
			'about'		=> __( 'Hakkında', 'namazvakti' ),
		);
		
		// Tab isimlerini filitrele
		$tabs = apply_filters( 'namazvakti_settings_tabs', $default_tabs);
		
		?><h2 class="nav-tab-wrapper"><?php
		
		$ctab = isset( $_GET['tab'] ) === false ? 'general' : $_GET['tab'];
		foreach( $tabs as $tab => $name )
		{
			$class = ( $tab == $ctab ) ? ' nav-tab-active' : '';
			echo "<a class='nav-tab$class' href='?page=namazvakti&tab=$tab'>$name</a>";
		}
		
		?>
        </h2>
        <div class="wrap">
        <?php
            // Tab içeriklerini göstermek için 'namazvakti_admin_page_' başlangıcı kullanarak diğer sayfaları ekler ve fonksiyonlarını çağırır.
            $this->__ayar_sayfasini_getir( $ctab );
        ?>
        </div>
        <?php
		
	}
	
	/*
		Ayar sayfası varsa getirir - yoksa yok der!
	*/
	private function __ayar_sayfasini_getir( $tab='genel' )
	{
		if( file_exists( NV_PLUGIN_DIR . 'include' . DIRECTORY_SEPARATOR . 'page.' . $tab .  '.php' ) )
		{
			include_once NV_PLUGIN_DIR . 'include' . DIRECTORY_SEPARATOR . 'page.' . $tab .  '.php';
		} else {
			_e( 'Ayarlar sayfası bulunamadı!', 'namazvakti' );
		}
	}
	
	
	/*
		Widgetleri ekle
	*/
	public function __widget_init()
	{
		register_widget( 'NV_Widget' );
	}
	
}

// Eklentiyi Çalıştır!
$namazvakti = new WP_Namazvakti();