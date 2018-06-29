var default_sehirler_select_value	= '<option value="0">' + eranvjs.sehir_sec + '</option>';
var default_ilceler_select_value	= '<option value="0">' + eranvjs.ilce_sec + '</option>';

function selectCity()
{
	var ulke = jQuery('#ulkeler').val();
	// Varsayılanları yükle
	jQuery('#sehirler').html(default_sehirler_select_value);
	jQuery('#ilceler').html(default_ilceler_select_value);
	
	
	if (ulke != 0)
	{
		// loader işleri
		var loader = jQuery('.loader');
		loader.show();
		
		jQuery.ajax({
			type:		'POST',
			url:		eranvjs.ajaxurl,
			data:		"action=ajax_action&do=getCities&country=" + ulke,
			success: 	function( data ) {
				
				var response = jQuery.parseJSON( data );
				
				if( response.durum == 'basarili' )
				{
					if(response.ilce == true) {
						// Şehir yok doğrudan ilçe,

						jQuery.each( response.veri, function(key, val) {
							var newOption = jQuery('<option />');
							jQuery('#ilceler').append(newOption);
							
							newOption.val(key);
							newOption.html(val);				
						});

						jQuery('#label_sehirler').hide();
						jQuery('#sehirler').hide();
						jQuery('#label_ilceler').show();
						jQuery('#ilceler').show();
						loader.hide();


					} else {
						// Şehir var - ilçeler bir sonrakinde!
						jQuery.each( response.veri, function(key, val) {
							var newOption = jQuery('<option />');
							jQuery('#sehirler').append(newOption);
							
							newOption.val(key);
							newOption.html(val);				
						});

						jQuery('#label_sehirler').show();
						jQuery('#sehirler').show();
						jQuery('#label_ilceler').show();
						jQuery('#ilceler').show();
						loader.hide();
					}
					
				} else {
					alert(eranvjs.hata_veri_cekilemedi);
					loader.hide();
				}
			}
		});
	}
}

function selectLocation()
{
	
	
	var ulke = jQuery('#ulkeler').val();
	var sehir = jQuery('#sehirler').val();
	
	
	jQuery('#ilceler').html(default_ilceler_select_value);

	if(sehir != 0) {
		var loader = jQuery('.loader');
		loader.show();

		jQuery.ajax({
			type:		'POST',
			url:		eranvjs.ajaxurl,
			data:		"action=ajax_action&do=getLocations&country=" + ulke + "&city=" + sehir,
			//dataType:	"json",
			success: 	function( data ) {
				
				var response = jQuery.parseJSON( data );
				
				if( response.durum == 'basarili' )
				{
					jQuery.each( response.veri, function(key, val) {
						var newOption = jQuery('<option />');
						jQuery('#ilceler').append(newOption);
						
						newOption.val(key);
						newOption.html(val);
					});
					loader.hide();
				} else {
					alert(eranvjs.hata_veri_cekilemedi);
					loader.hide();
				}
			}
		});
	}
}


function getTimes()
{
	// önce butonu kapat
	var button = jQuery('#get_button');
	button.attr('disabled','disabled');
	
	// verileri al ve kontrol et!
	var ulke = jQuery('#ulkeler').val();
	var sehir = jQuery('#sehirler').val();
	var ilce = jQuery('#ilceler').val();
	
	if(ulke == 0)
	{
		alert(eranvjs.ulke_secilmemis);
		button.removeAttr('disabled');
	} else {
		if(sehir == 0 && ilce == 0) {
			alert(eranvjs.sehir_secilmemis);
			button.removeAttr('disabled');
		}
		else if(sehir != 0 && ilce == 0) {
			alert(eranvjs.ilce_secilmemis);
			button.removeAttr('disabled')
		} else {
			vakital(ilce);
			button.removeAttr('disabled')
		}
	}
}


function vakital(ilce)
{
	var loader = jQuery('.loader');
	loader.show();
		
	jQuery.ajax({
		type:		'POST',
		url:		eranvjs.ajaxurl,
		data:		"action=ajax_action&do=getTimes&town=" + ilce,
		success: 	function( data ) {
			
			var response = jQuery.parseJSON( data );
			
			if( response.durum == 'basarili' )
			{
				// veriler yerlerine konulacak
				jQuery('.namazvakti .yer').html((response.veri.yer_adi).replace("-", "<br />"));
				jQuery('.zaman .hicri').html(response.veri.vakit.hicri_uzun);
				jQuery('#imsak .vakit_saati').html(response.veri.vakit.imsak);
				jQuery('#gunes .vakit_saati').html(response.veri.vakit.gunes);
				jQuery('#ogle .vakit_saati').html(response.veri.vakit.ogle);
				jQuery('#ikindi .vakit_saati').html(response.veri.vakit.ikindi);
				jQuery('#aksam .vakit_saati').html(response.veri.vakit.aksam);
				jQuery('#yatsi .vakit_saati').html(response.veri.vakit.yatsi);
				
				loader.hide();
				flipAyarlar();
				sayaci_baslat();
			} else {
				loader.hide();
				alert(eranvjs.hata_veri_cekilemedi);
			}
		}
	});
}

function flipAyarlar()
{
	var durum = jQuery('.namazvakti .yer').attr('data-durum');
	if (durum == 'kapali')
	{
		jQuery('.namazvakti_saatler').slideUp('slow');
		jQuery('.namazvakti_ayarlar').slideDown('slow');
		jQuery('.namazvakti .yer').attr('data-durum', 'acik');
	} else {
		jQuery('.namazvakti_ayarlar').slideUp('slow');
		jQuery('.namazvakti_saatler').slideDown('slow');
		jQuery('.namazvakti .yer').attr('data-durum', 'kapali');
	}
}

function hangi_vakitteyiz()
{
	var	imsak_val	= jQuery('#imsak .vakit_saati').html().split(":"),
		gunes_val	= jQuery('#gunes .vakit_saati').html().split(":"),
		ogle_val	= jQuery('#ogle .vakit_saati').html().split(":"),
		ikindi_val	= jQuery('#ikindi .vakit_saati').html().split(":"),
		aksam_val	= jQuery('#aksam .vakit_saati').html().split(":"),
		yatsi_val	= jQuery('#yatsi .vakit_saati').html().split(":");
		
	var simdi		= new Date(),
		simdiInt	= simdi.valueOf();
	
	var	imsak	= new Date(simdi.getFullYear(),simdi.getMonth(),simdi.getDate(),imsak_val[0],imsak_val[1],0,0).valueOf(),
		gunes	= new Date(simdi.getFullYear(),simdi.getMonth(),simdi.getDate(),gunes_val[0],gunes_val[1],0,0).valueOf(),
		ogle	= new Date(simdi.getFullYear(),simdi.getMonth(),simdi.getDate(),ogle_val[0],ogle_val[1],0,0).valueOf(),
		ikindi	= new Date(simdi.getFullYear(),simdi.getMonth(),simdi.getDate(),ikindi_val[0],ikindi_val[1],0,0).valueOf(),
		aksam	= new Date(simdi.getFullYear(),simdi.getMonth(),simdi.getDate(),aksam_val[0],aksam_val[1],0,0).valueOf(),
		yatsi	= new Date(simdi.getFullYear(),simdi.getMonth(),simdi.getDate(),yatsi_val[0],yatsi_val[1],0,0).valueOf();
		
	var vakitler = Array('imsak', 'gunes', 'ogle', 'ikindi', 'aksam', 'yatsi');
		
	var vakit = '';
	if (simdiInt > imsak && simdiInt <= gunes)
	{
		vakit = vakitler[0];
		sonraki_vakit = vakitler[1];
	}
	else if (simdiInt > gunes && simdiInt <= ogle)
	{
		vakit = vakitler[1];
		sonraki_vakit = vakitler[2];
	}
	else if (simdiInt > ogle && simdiInt <= ikindi)
	{
		vakit = vakitler[2];
		sonraki_vakit = vakitler[3];
	}
	else if (simdiInt > ikindi && simdiInt <= aksam)
	{
		vakit = vakitler[3];
		sonraki_vakit = vakitler[4];
	}
	else if (simdiInt > aksam && simdiInt <= yatsi)
	{
		vakit = vakitler[4];
		sonraki_vakit = vakitler[5];
	}
	else {
		vakit = vakitler[5];
		sonraki_vakit = vakitler[0];
	}
	jQuery.each( vakitler, function( i, value ) {
		jQuery('#' + value).removeClass('active');
	});
	jQuery('#' + vakit).addClass('active');
	return sonraki_vakit;	
}


function sonraki_gun(sor)
{
	var	bugun	= new Date();
	
	var	yil	= bugun.getFullYear(),
		ay	= bugun.getMonth();
		
	var bulunan_gun, bulunan_ay;
	
	/*
		aylar
		0 ocak, 1 şubat, 2 mart, 3 nisan, 4 mayıs, 5 haziran, 6 temmuz, 7 ağustos, 8 eylül, 9 ekim, 10 kasım, 11 aralık
	*/
	
	// Sorgualamalara başla
	if (ay == 1) // aylardan şubatsa
	{
		// gün 28 mi?
		if (sor == 28)
		{
			// artık yil ise, değil ise
			if(yil%4 == 0)
			{
				bulunan_gun	= 29;
				bulunan_ay	= ay;
			} else {
				bulunan_gun	= 1;
				bulunan_ay	= 2;
			}
		} else {
			bulunan_gun	= sor+1;
			bulunan_ay	= ay;
		}
	}
	// 30 çeken aylara bakalım ....
	else if ( ay == 3 || ay == 5 || ay == 8 || ay == 10 )
	{
		if (sor == 30)
		{
			bulunan_gun	= 1;
			bulunan_ay	= ay+1;
		} else {
			bulunan_gun	= sor+1;
			bulunan_ay	= ay;
		}
	}
	// aralık dışında 31 çekenler :)
	else if (ay == 0 || ay == 2 || ay == 4 || ay == 6 || ay == 7 || ay == 9 )
	{
		if(sor == 31)
		{
			bulunan_gun	= 1;
			bulunan_ay	= ay+1;
		} else {
			bulunan_gun	= sor+1;
			bulunan_ay	= ay;
		}
	}
	// ay aralık ise
	else if (ay == 11)
	{
		if(sor == 31)
		{
			bulunan_gun	= 1;
			bulunan_ay	= 0;
		} else {
			bulunan_gun	= sor+1;
			bulunan_ay	= ay;
		}
	}
	else {
		bulunan_gun	= 1;
		bulunan_ay	= 0;
	}
	
	return bulunan_gun+'_'+bulunan_ay;
	
}



function sayaci_baslat()
{
	var	sayac_alani = jQuery('.kalanvakit_zaman');
	var kalan_alani = jQuery('.kalanvakit_text');
	var vakit = hangi_vakitteyiz();
	var vakit_saat = jQuery('#' + vakit + ' .vakit_saati').html().split(":");
	var bugunun_gunu = jQuery('.zaman .bugun').html().split(" ");
	
	var simdi = new Date();
	var sonraki_gun_ve_ay = sonraki_gun( simdi.getDate() ).split('_');
	
	
	if(vakit == 'imsak' && parseInt(bugunun_gunu[0]) == simdi.getDate() )
	{
		var tarih = new Date(simdi.getFullYear(),sonraki_gun_ve_ay[1],sonraki_gun_ve_ay[0],vakit_saat[0],vakit_saat[1],0,0);
	} else {
		var tarih = new Date(simdi.getFullYear(),simdi.getMonth(),simdi.getDate(),vakit_saat[0],vakit_saat[1],0,0);
	}
	
	// şu vakte bu kadar kaldı de!
	kalan_alani.html(eranvjs[vakit]);
	

	jQuery('#countdown_dashboard').stopCountDown();
	
	jQuery('#countdown_dashboard').setCountDown({
		targetDate: {
			'day': 		tarih.getDate(),
			'month': 	tarih.getMonth()+1,
			'year': 	simdi.getFullYear(),
			'hour': 	vakit_saat[0],
			'min': 		vakit_saat[1],
			'sec': 		0
		},
		onComplete: function() { sayaci_baslat(); }
	});
	
	jQuery('#countdown_dashboard').startCountDown();

}


jQuery(document).ready(function() {
	jQuery('#countdown_dashboard').countDown({
		targetOffset: {
			'day': 		0,
			'month': 	0,
			'year': 	0,
			'hour': 	0,
			'min': 		0,
			'sec': 		0
		},
		onComplete: function() { sayaci_baslat(); }
	});
	sayaci_baslat();
});