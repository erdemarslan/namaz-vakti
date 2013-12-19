<?php
/*
Plugin Name: Diyanet İşleri Namaz Vakti Eklentisi
Plugin URI: http://www.erdemarslan.com/wordpress/18-12-2013/535-namaz-vakitleri-wordpress-eklentisi-widget.html
Description: Bu eklenti Diyanet İşleri Başkanlığından namaz vakitlerini alır ve gösterir.
Version: 1.0.2
Author: Erdem ARSLAN
Author URI: http://www.erdemarslan.com
*/

# Bu widgetde şehir secimleri kullanıcıya bağlıdır.

// Tanımlamalar
define('NV_VERSION', '1.0.2');
define('NV_OPTION_SEHIRLER', 'namazvakti_sehirler'); // veritabanı şehirler
define('NV_OPTION_VARSAYILAN_SEHIR', 'namazvakti_varsayilan_sehir'); // veritabanı varsayılan şehir
define('NV_OPTION_API_ANAHTARI', 'namazvakti_api_anahtari');
define('NV_SEHIR_ID', 'namazvakti_sehir_ID');
define('NV_SEHIR_ADI', 'namazvakti_sehir_adi');


Class NV_Widget extends WP_Widget
{
	private $cache;
	private $version;
	private $anahtar;
	
	
	public function __construct()
	{
		//global $version;
		//NV_VERSION = $version;
		//NV_VERSION = NV_VERSION;
		// Widgeti kaydet init et
		//register_widget('NV_Widget');
		// Still ve JS dosyalarını ayarla
		wp_enqueue_script( 'jquery');
		wp_enqueue_style( 'era_namazvakti_style', plugins_url( "/assets/css/namazvakti-style.css", __FILE__ ), array(), NV_VERSION);
		wp_enqueue_script( 'era-ajax-request', plugins_url( "/assets/js/namazvakti.js", __FILE__), array( 'jquery' ), NV_VERSION );
		wp_localize_script( 'era-ajax-request', 'EraAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
				
		// Ajax işlemlerini ekle
		add_action( 'wp_ajax_ajax_action', array( &$this, 'namazvakti_ajax' ) ); // ajax for logged in users
		add_action( 'wp_ajax_nopriv_ajax_action', array( &$this, 'namazvakti_ajax' ) ); // ajax for not logged in users
		
		// Cache folderını ayarla
		require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'include/cache.class.php';
		$this->cache = new NV_Cache( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR );
		
		$params = array(
			'description'	=> 'Bu widget kullanıcıya namaz vakitlerini gösterir. Şehri kullanıcı seçer.',
			'name'		=> 'Namaz Vakitleri - Kullanıcı Tanımlı'
		);
		
		$this->anahtar = get_option( NV_OPTION_API_ANAHTARI );
		parent::__construct('NV_Userselect','',$params);
	}
	
	
	public function form($instance)
	{
		extract($instance);
		?>
        <p>
        	<label for="<?php echo $this->get_field_id('baslik'); ?>">Widget Başlığı: </label>
            <input
            	class="widefat"
                id="<?php echo $this->get_field_id('baslik'); ?>"
                name="<?php echo $this->get_field_name('baslik'); ?>"
                value="<?php if ( isset($baslik) ) echo esc_attr($baslik); ?>" />
        </p>
        <?php
	}
	
	private function _get_ayyil()
	{
		$aylar = array('', 'Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık');
		return $aylar[date('m')] . ' ' . date('Y');
	}
	
	public function widget($args, $instance)
	{		
		extract($args);
		extract($instance);
		
		$baslik = apply_filters('widget_title', $baslik);
		
		$vtdeki_sehirler = json_decode(get_option( NV_OPTION_SEHIRLER ), TRUE);
		$varsayilan_sehir_id = get_option( NV_OPTION_VARSAYILAN_SEHIR );
		$varsayilan_sehir_adi = $vtdeki_sehirler[$varsayilan_sehir_id];
		
		$gun = date('d.m.Y', time());
		$vakit = $this->namazvakti_al_vakitler($varsayilan_sehir_id);
		$vakit = $vakit->$gun;
		
		//print_r($vakit);
		
		echo $before_widget;
			
			if(empty($this->anahtar)) {  echo 'NamazVakti için API Anahtarı kaydedilmemiş!' . $after_widget; } else {
		
			echo $before_title . $baslik . $after_title;			
			?>
			<div class="wrap">
				
				<div class="tarih">
					<div class="gun"><?php echo date('d', time()); ?></div>
					<div class="ayyil"><?php echo $this->_get_ayyil(); ?></div>
					<div class="hicri"><?php echo $vakit->hicri; ?></div>
					<div class="sehir"><?php echo $varsayilan_sehir_adi; ?></div>
				</div>
				
				<div class="secim">
					<select id="nmz_ilceler" onChange="al_vakitler();">
						<?php
						if (count($vtdeki_sehirler) > 0)
						{
						?>
						<option value="0" selected disabled>Lütfen bir şehir seçiniz</option>
						<?php
							foreach ($vtdeki_sehirler as $id=>$adi)
							{
							?>
							<option value="<?php echo $id; ?>"><?php echo $adi; ?></option>
							<?php
							}
						} else {
						?>
						<option value="0" selected disabled>Veritabanına şehir eklenmemiş!</option>
						<?php
						}
						?>
						
					</select>
				</div>
			
			
			
			
				<div class="namaz">
					<div class="namaz-vakit">
						<div id="namazvakti_sonuclist">
							<table cellspacing="0" cellpadding="0" id="vakitler">
							<tbody>
								<tr>
								<th>İmsak</th>
								<td class="imsak"><?php echo $vakit->imsak; ?></td>
								</tr>
								
								<tr>
								<th>Güneş</th>
								<td class="gunes"><?php echo $vakit->gunes; ?></td>
								</tr>
								
								<tr>
								<th>Öğle</th>
								<td class="ogle"><?php echo $vakit->ogle; ?></td>
								</tr>
								
								<tr>
								<th>İkindi</th>
								<td class="ikindi"><?php echo $vakit->ikindi; ?></td>
								</tr>
								
								<tr>
								<th>Akşam</th>
								<td class="aksam"><?php echo $vakit->aksam; ?></td>
								</tr>
								
								<tr>
								<th>Yatsı</th>
								<td class="yatsi"><?php echo $vakit->yatsi; ?></td>
								</tr>
								
								<tr>
								<th>Kıble</th>
								<td class="kible"><?php echo $vakit->kible; ?></td>
								</tr>
							</tbody>
						</table>
						</div>
					</div>
				</div>
			
			</div>
			<?php
			
			
		echo $after_widget;
			}
	}
	
	private function get_data($url)
	{
		$dosya = md5($url) . '.json';
		
		if($this->cache->_sor_cache($dosya))
		{
			$veriler = $this->cache->_oku_cache($dosya);
			return $veriler->veri;
		} else {
			$veri = wp_remote_get($url);
			$veri = json_decode($veri['body']);
			// veriler kontrol et!
			if($veri->durum == 'basarili')
			{
				$this->cache->
				_yaz_cache($dosya,json_encode($veri));
				return $veri->veri;
			} else {
				return new stdClass;
			}
		}
	}
	
	
	private function namazvakti_al_vakitler($sehir)
	{
		$url = 'http://api.eralabs.net/namazvakti/' . $this->anahtar .'/vakitler/sehir:' . $sehir .'.json';
		return $this->get_data($url);
	}
	
	public function namazvakti_ajax()
	{
		//extract($_POST);
		switch($_POST['do'])
		{
		
			case 'alVakit' :
				$veri = $this->namazvakti_al_vakitler($_POST['sehir']);
				
				if (count($veri) > 0)
				{
					$gun = date('d.m.Y', time());
					$bugun = $veri->$gun;
					
					echo json_encode(array('durum' => 'basarili', 'veri' => $bugun));
					die();
				} else {
					echo json_encode(array('durum' => 'hata', 'veri' => ''));
					die();
				}
			break;
		}
	}
	
	
	
}

// Widgeti aktifleştir
add_action( 'widgets_init', function() {
	register_widget('NV_Widget');
});

register_activation_hook( __FILE__, function() {
	// option değerlerinin veritabanına yerleştir!
	if ( get_option( NV_OPTION_SEHIRLER ) === FALSE )
	{
		add_option( NV_OPTION_SEHIRLER, '{"1":"ADANA","2":"ADIYAMAN","3":"AFYON","4":"A\u011eRI","68":"AKSARAY","5":"AMASYA","6":"ANKARA","7":"ANTALYA","74":"ARDAHAN","8":"ARTV\u0130N","9":"AYDIN","10":"BALIKES\u0130R","76":"BARTIN","72":"BATMAN","69":"BAYBURT","11":"B\u0130LEC\u0130K","12":"B\u0130NG\u00d6L","13":"B\u0130TL\u0130S","14":"BOLU","15":"BURDUR","16":"BURSA","17":"\u00c7ANAKKALE","18":"\u00c7ANKIRI","19":"\u00c7ORUM","20":"DEN\u0130ZL\u0130","21":"D\u0130YARBAKIR","81":"D\u00dcZCE","22":"ED\u0130RNE","23":"ELAZI\u011e","24":"ERZ\u0130NCAN","25":"ERZURUM","26":"ESK\u0130\u015eEH\u0130R","27":"GAZ\u0130ANTEP","28":"G\u0130RESUN","29":"G\u00dcM\u00dc\u015eHANE","30":"HAKKAR\u0130","31":"HATAY","75":"I\u011eDIR","32":"ISPARTA","34":"\u0130STANBUL","35":"\u0130ZM\u0130R","46":"KAHRAMANMARA\u015e","77":"KARAB\u00dcK","70":"KARAMAN","36":"KARS","37":"KASTAMONU","38":"KAYSER\u0130","71":"KIRIKKALE","39":"KIRKLAREL\u0130","40":"KIR\u015eEH\u0130R","79":"K\u0130L\u0130S","41":"KOCAEL\u0130","42":"KONYA","43":"K\u00dcTAHYA","44":"MALATYA","47":"MARD\u0130N","33":"MERS\u0130N","48":"MU\u011eLA","49":"MU\u015e","50":"NEV\u015eEH\u0130R","51":"N\u0130\u011eDE","52":"ORDU","80":"OSMAN\u0130YE","53":"R\u0130ZE","54":"SAKARYA","55":"SAMSUN","56":"S\u0130\u0130RT","57":"S\u0130NOP","58":"S\u0130VAS","63":"\u015eANLIURFA","73":"\u015eIRNAK","59":"TEK\u0130RDA\u011e","60":"TOKAT","61":"TRABZON","62":"TUNCEL\u0130","64":"U\u015eAK","65":"VAN","78":"YALOVA","66":"YOZGAT","67":"ZONGULDAK"}');
	}
	
	if ( get_option( NV_OPTION_VARSAYILAN_SEHIR ) === FALSE )
	{
		add_option( NV_OPTION_VARSAYILAN_SEHIR, '34');
	}
	
	if ( get_option( NV_OPTION_API_ANAHTARI ) === FALSE )
	{
		add_option( NV_OPTION_API_ANAHTARI, '' );
	}
});

##########################################################################
# ADMIN BÖLÜMÜ                                                           #
##########################################################################

# Admin menüsünü ekle
add_action( 'admin_menu', function() {
	add_options_page( 'Namaz Vakti Ayarları', 'Namaz Vakti Ayarları', 'manage_options', 'namazvakti', 'namazvakti_ayarlari' );
});


// Eklentiye extra linkler ekle
add_filter('plugin_action_links', 'namazvakti_ayarlar_linkleri', 10, 2);
function namazvakti_ayarlar_linkleri($links, $file) {
 
    if ( $file == 'namazvakti/namazvakti.php' ) {
        
	$settings	= sprintf( '<a href="%s"> %s </a>', admin_url( 'options-general.php?page=namazvakti' ), 'Ayarlar' );
	$eralabs	= sprintf( '<a href="%s" target="_blank"> %s </a>', 'http://api.eralabs.net/namazvakti', 'EraLabs' );
	
	array_unshift( $links, $settings );

	$links[] = $eralabs;	
    }
    return $links;
 
}

# Admin sayfasını yükler...
function namazvakti_ayarlari()
{
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( 'Bu sayfaya erişim izniniz bulunmuyor.' );
	}
	
	?>
	<h2>Wordpress için Namaz Vakitleri</h2>	
	<?php
	
	$default_tabs = array(
		'general'	=> 'Genel Ayarlar',
		'add'		=> 'Şehir Ekle',
		'list'		=> 'Şehirleri Listele',
		'about'		=> 'Hakkında'	
	);
	
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
		$tab_function = 'namazvakti_admin_page_' . $ctab;
		$tab_function();
	?>
	</div>
	<?php
}

function namazvakti_admin_page_general()
{
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'include/admin.page.general.php';
}

function namazvakti_admin_page_add()
{
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'include/admin.page.add_city.php';
}

function namazvakti_admin_page_list()
{
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'include/admin.page.list_city.php';
}

function namazvakti_admin_page_about()
{
	echo '<div class="wrap"><p><h3>Namaz Vakitleri</h3><br>
	Wordpress için Namaz Vakitleri eklentisi, Erdem Arslan tarafından yazılmıştır. Bu eklentinin kullanılabilmesi için
	<a href="http://api.eralabs.net/api-anahtari" target="_blank">http://api.eralabs.net/api-anahtari</a> adresinden
	API Anahtarının temin edilmesi gerekmektedir. Bu eklenti namaz vakitleriyle ilgili bilgileri EraLabs sunucuları üzerinden almaktadır.<br>
	Namaz vakitlerini çekmek istediğiniz şehrin, ID numarasını ve şehrin ismini veritabanına ekletinin ayarlarındaki bölümden eklemeniz gerekmektedir.
	Şehirlerin ID numaralarını ve isimlerini <a href="http://api.eralabs.net/namazvakti" target="_blank">http://api.eralabs.net/namazvakti</a> adresinden elde edebilirsiniz.
	<br><br>
	Bu eklenti tamamen ücretsizdir. Ancak API sunucusunu kullanım ile ilgili ücret ödemeniz gerekebilir. Bunun ile ilgili şartları lütfen EraLabs üzerinden kontrol ediniz.
	<br>Allah razı olsun demeniz yeterlidir.
	</p></div>';
}

