function al_vakitler()
{
	var sehir	= jQuery('#nmz_ilceler').val();
	var sehiradi = jQuery('#nmz_ilceler option:selected').text();
	
	jQuery('.sehir').html(sehiradi);
	
	
	jQuery('.imsak').html('__:__');
	jQuery('.gunes').html('__:__');
	jQuery('.ogle').html('__:__');
	jQuery('.ikindi').html('__:__');
	jQuery('.aksam').html('__:__');
	jQuery('.yatsi').html('__:__');
	jQuery('.kible').html('__:__');
	
	jQuery.ajax({
		type:	"POST",
		url:	EraAjax.ajaxurl,
		data:	"action=ajax_action&do=alVakit&sehir=" + sehir,
		success: function(data) {
			
			var response = jQuery.parseJSON(data);
			if(response.durum == 'basarili')
			{
				
				jQuery('.hicri').html(response.veri.hicri);
				
				jQuery('.imsak').html(response.veri.imsak);
				jQuery('.gunes').html(response.veri.gunes);
				jQuery('.ogle').html(response.veri.ogle);
				jQuery('.ikindi').html(response.veri.ikindi);
				jQuery('.aksam').html(response.veri.aksam);
				jQuery('.yatsi').html(response.veri.yatsi);
				jQuery('.kible').html(response.veri.kible);
				
			} else {
				alert('Vakit bilgileri alınamadı. Daha sonra tekrar deneyiniz.');
				//jQuery('#namazvakti_sonuclist').html('Vakit bilgileri alınamadı!');
			}
		}
	});
}