<?php if( !defined('NV_NAME') ) die('You can not access this file directly!');

Class NV_Widget extends WP_Widget
{
	// Değişkenler
	private $nv;
	private $plugin;
	
	/*
		Yapılandırıcı Fonksiyon
	*/
	public function __construct()
	{
		global $nv, $namazvakti;
		$this->nv = $nv;
		$this->plugin = $namazvakti;
		
		$params = array(
			'name'			=> __('Namaz Vakitleri', 'namazvakti'),
			'description'	=> __('Bu widget namaz vakitlerini gösterir.', 'namazvakti')
		);
		parent::__construct('NV_Widget','',$params);
	}
	
	/*
		form - admin paneli bileşenlerde yer alır
	*/
	public function form( $instance )
	{
		$baslik		= isset($instance['baslik'])	? esc_attr( $instance['baslik'] )	: '';
		?>
        <p>
        	<label for ="<?php echo $this->get_field_id( 'baslik' ); ?>"><strong><?php echo __( 'Widget Başlığı' , 'namazvakti' ); ?></strong>  
            <input class="widefat" id="<?php echo $this->get_field_id( 'baslik' ); ?>" name="<?php echo $this->get_field_name( 'baslik' ); ?>" type="text" value="<?php echo $baslik; ?>" />
            </label>
        </p>
        <?php
	}
	
	/*
		Widget - kullanıcının göreceği şey!
	*/
	public function widget( $args, $instance )
	{
		extract($args, EXTR_SKIP);
		$title = $instance['baslik'];
		
		echo $before_widget;
		
		if ( $title )
		{
			echo $before_title . $title . $after_title; 
		}
		
		// Tanımlamaları yap!
		$aylar = array( '01' => __('Ocak', 'namazvakti'), '02' => __('Şubat', 'namazvakti'), '03' => __('Mart', 'namazvakti'), '04' => __('Nisan', 'namazvakti'), '05' => __('Mayıs', 'namazvakti'), '06' => __('Haziran', 'namazvakti'), '07' => __('Temmuz', 'namazvakti'), '08' => __('Ağustos', 'namazvakti'), '09' => __('Eylül', 'namazvakti'), '10' => __('Ekim', 'namazvakti'), '11' => __('Kasım', 'namazvakti'), '12' => __('Aralık', 'namazvakti') );
		
		$varsayilan_ulke = isset($_SESSION[NV_DB_DEFAULT_COUNTRY_NAME]) ? $_SESSION[NV_DB_DEFAULT_COUNTRY_NAME] : get_option( NV_DB_DEFAULT_COUNTRY_NAME );
		$varsayilan_sehir = isset($_SESSION[NV_DB_DEFAULT_CITY_NAME]) ? $_SESSION[NV_DB_DEFAULT_CITY_NAME] : get_option( NV_DB_DEFAULT_CITY_NAME );
		$varsayilan_ilce = isset($_SESSION[NV_DB_DEFAULT_TOWN_NAME]) ? $_SESSION[NV_DB_DEFAULT_TOWN_NAME] : get_option( NV_DB_DEFAULT_TOWN_NAME );
		
		
		
		$yer = $varsayilan_sehir == $varsayilan_ilce ? $varsayilan_ulke . '<br>' . $varsayilan_sehir : $varsayilan_sehir . '<br>' . $varsayilan_ilce;
		
		// vakitleri al!
		$vakit = $this->nv->vakit( $varsayilan_ilce, $varsayilan_ulke);
		
		
		if( $vakit['durum'] == 'basarili' )
		{
			$vakit = $vakit['veri'];
			
			$hangi_vakit = $this->hangi_vakitteyiz($vakit);
		
			// Ayarlar kısmının verilerini çekelim
			// ülkeler!
			$ulkeler = $this->nv->ulkeler();
			
		// Buraya widget ile ilgili şeyler gelecek!
		?>
        <div class="namazvakti">
        
        
        	<div class="yer" data-durum="kapali" onClick="flipAyarlar();">
            	<?php echo $yer; ?>
            </div>
            
            <div class="namazvakti_ayarlar">
        		<label for="ulkeler"><?php _e('Ülke Seçiniz', 'namazvakti'); ?></label>
                <select name="ulkeler" id="ulkeler" onChange="selectCity();">
                	<option value="0"><?php _e('Lütfen bir ülke seçiniz', 'namazvakti'); ?></option>
                    <option value="TURKIYE"><?php _e('TURKIYE', 'namazvakti'); ?></option>
                    <?php
						foreach ($ulkeler as $value => $text)
						{
							if($value != 'TURKIYE')
							{
								echo '<option value="' . $value . '">' . $text . '</option>';
							}
						}
					?>
                </select>


                <label for="sehirler"><?php _e('Şehir Seçiniz', 'namazvakti'); ?></label>
                <select name="sehirler" id="sehirler" onChange="selectLocation();">
                	<option value="0"><?php _e('Lütfen bir şehir seçiniz', 'namazvakti'); ?></option>                    
                </select>
                
                
                
                <label id="label_ilceler" for="ilceler"><?php _e('İlçe Seçiniz', 'namazvakti'); ?></label>
                <select name="ilceler" id="ilceler">
                	<option value="0"><?php _e('Lütfen bir ilçe seçiniz', 'namazvakti'); ?></option>                    
                </select>
                
                <div class="buton_alani">
                	<div class="btn_kendisi"><button type="button" id="get_button" class="nvButton" onClick="getTimes();"><?php _e('Vakti Al', 'namazvakti'); ?></button></div>
                    
                    <div class="loader"><img src="<?php echo plugins_url( 'assets/img/loader.gif', NV_NAME ); ?>"/></div>
                </div>
        	</div>
            
            
            <div class="namazvakti_saatler">
            <div class="zaman">
            	<div class="bugun"><?php echo date('d') . ' ' . $aylar[date('m')]; ?></div>
                <div class="hicri"><?php echo $vakit['hicritarih']; ?></div>
                <div class="kalanvakit_text"></div>
                <div class="kalanvakit_zaman">
                    <!-- Countdown dashboard start -->
                    <div id="countdown_dashboard">
                        <div class="dash weeks_dash">
                            <div class="digit">0</div>
                            <div class="digit">0</div>
                            <div class="dash_title">:</div>
                        </div>
            
                        <div class="dash days_dash">
                            <div class="digit">0</div>
                            <div class="digit">0</div>
                            <div class="dash_title">:</div>
                        </div>
            
                        <div class="dash hours_dash">
                            <div class="digit">0</div>
                            <div class="digit">0</div>
                            <div class="dash_title">:</div>
                        </div>
            
                        <div class="dash minutes_dash">
                            <div class="digit">0</div>
                            <div class="digit">0</div>
                            <div class="dash_title">:</div>
                        </div>
            
                        <div class="dash seconds_dash">
                            <div class="digit">0</div>
                            <div class="digit">0</div>
                        </div>
            
                    </div>
                    <!-- Countdown dashboard end -->                
                </div>
            </div>
            
            <div class="vakitler">
            
            	<div id="imsak" class="vakit">
                	<div class="vakit_adi"><?php _e('İmsak', 'namazvakti'); ?></div>
                    <div class="vakit_saati"><?php echo $vakit['imsak']; ?></div>
                </div>
                
                <div id="gunes" class="vakit">
                	<div class="vakit_adi"><?php _e('Güneş', 'namazvakti'); ?></div>
                    <div class="vakit_saati"><?php echo $vakit['gunes']; ?></div>
                </div>
                
                <div id="ogle" class="vakit">
                	<div class="vakit_adi"><?php _e('Öğle', 'namazvakti'); ?></div>
                    <div class="vakit_saati"><?php echo $vakit['ogle']; ?></div>
                </div>
                
                <div id="ikindi" class="vakit">
                	<div class="vakit_adi"><?php _e('İkindi', 'namazvakti'); ?></div>
                    <div class="vakit_saati"><?php echo $vakit['ikindi']; ?></div>
                </div>
                
                <div id="aksam" class="vakit">
                	<div class="vakit_adi"><?php _e('Akşam', 'namazvakti'); ?></div>
                    <div class="vakit_saati"><?php echo $vakit['aksam']; ?></div>
                </div>
                
                <div id="yatsi" class="vakit">
                	<div class="vakit_adi"><?php _e('Yatsı', 'namazvakti'); ?></div>
                    <div class="vakit_saati"><?php echo $vakit['yatsi']; ?></div>
                </div>
                
                <div id="kible" class="vakit">
                	<div class="vakit_adi"><?php _e('Kıble', 'namazvakti'); ?></div>
                    <div class="vakit_saati"><?php echo $vakit['kiblesaati']; ?></div>
                </div>
            </div>
            </div>
        
        </div>
		<?php
		} else {
			echo 'İstenilen şehre ait veriler alınamadı!';
		}
		
		
		echo $after_widget;
	}
	
	
	private function hangi_vakitteyiz($vakitler)
	{
		$imsak	= strtotime( date('d.m.Y') . ' ' . $vakitler['imsak'] . ':00');
		$gunes	= strtotime( date('d.m.Y') . ' ' . $vakitler['gunes'] . ':00');
		$ogle	= strtotime( date('d.m.Y') . ' ' . $vakitler['ogle'] . ':00');
		$ikindi	= strtotime( date('d.m.Y') . ' ' . $vakitler['ikindi'] . ':00');
		$aksam	= strtotime( date('d.m.Y') . ' ' . $vakitler['aksam'] . ':00');
		$yatsi	= strtotime( date('d.m.Y') . ' ' . $vakitler['yatsi'] . ':00');
		
		$simdi = strtotime(date('d.m.Y H:i:s'));
				
		if ($simdi > $yatsi)
		{
			return 'yatsi';
		}
		elseif ($simdi <= $yatsi AND $simdi > $aksam)
		{
			return 'aksam';
		}
		elseif ($simdi <= $aksam AND $simdi > $ikindi)
		{
			return 'ikindi';
		}
		elseif ($simdi <= $ikindi AND $simdi > $ogle)
		{
			return 'ogle';
		}
		elseif ($simdi <= $ogle AND $simdi > $gunes)
		{
			return 'gunes';
		} else {
			return 'imsak';
		}
		
	}
}