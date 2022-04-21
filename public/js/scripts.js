jQuery(function($){
		
	var FEED = window.FEED || {};	
	
	//------ TWEETS ------//
		
	FEED.TWEET = function() {					
		$('.tweets_feed').twittie({
			template: 
			'<div class="tweet_user">'+
				'<span class="icon-twitter"><i class="fa fa-twitter"></i></span>'+
				'<span class="username">{{screen_name}}</span>'+
			'</div>'+
			'<div class="tweet_text">'+
				'{{tweet}}'+
			'</div>'+
			'<div class="tweet_time">'+
				'<a href="{{url}}">{{date}}</a>'+
			'</div>'
			,
		}, function(){
			$(".tweets_feed").owlCarousel({
	
				pagination : true,
				navigation : true,
				autoPlay: true,
				singleItem: true
			});
		});
	}
	
	$(document).ready(function(){
			// FEED.TWEET();
	});

});

window.pieChart = new Chart(document.getElementById('chart_per_jenis_aset'), {
    type: 'pie',
    data: {
        labels: [
	        'Tanah', 
	        'Peralatan dan Mesin', 
	        'Gedung dan Bangunan', 
	        'Jalan, Jaringan dan Irigrasi', 
	        'Aset Tetap Lainya', 
	        'Kontruksi Dalam Pengerjaan'
        ],
        datasets: [
            {
                label: 'Total Nilai Per Jenis Aset',
                data: [433618589332, 784749216828.34, 935989409850.77, 4799381690744.73, 23458710185.60, 0],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                	'rgba(255, 159, 64, 1)'
                ]
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    font: {
                        size: 16
                    }
                }
            },
            tooltip: {
            	bodyFont: {
            		size: 16
            	},
            	backgroundColor: 'rgba(0, 0, 0, 0.8)',
            	boxPadding: 5
            },
        },
        animation: {
		  	onProgress: function() {
			    const ctx = this.ctx;
			    ctx.textAlign = 'center';
			    ctx.textBaseline = 'bottom';

			    let dataSum = 0;
			    if(this._sortedMetasets.length > 0 && this._sortedMetasets[0].data.length > 0) {
			      	const dataset = this._sortedMetasets[0].data[0].$context.dataset;
			      	dataSum = dataset.data.reduce((p, c) => p + c, 0);
			    }
			    if(dataSum <= 0) return;

			    this._sortedMetasets.forEach(meta => {
			      	meta.data.forEach(metaData => {
				        const dataset = metaData.$context.dataset;
				        const datasetIndex = metaData.$context.dataIndex;
				        const value = dataset.data[datasetIndex];
				        const percent = (Math.round(value / dataSum * 1000) / 10) + '%';
				        const mid_radius = metaData.innerRadius + (metaData.outerRadius - metaData.innerRadius) * 0.7;
				        const start_angle = metaData.startAngle;
				        const end_angle = metaData.endAngle;
				        if(start_angle === end_angle) return; // hidden
				        const mid_angle = start_angle + (end_angle - start_angle) / 2;

				        const x = mid_radius * Math.cos(mid_angle);
				        const y = mid_radius * Math.sin(mid_angle);

				        ctx.fillStyle = '#fff';
				        ctx.fillText(formatRupiah(value), metaData.x + x, metaData.y + y);
				        ctx.fillText(percent, metaData.x + x, metaData.y + y + 20);
			      	});
			    });
		  	}
		}
    }
});

var data_skpd = [{"Sekretariat Dewan Perwakilan Rakyat Daerah":28238692348.52},{"Sekretariat Daerah":120569070704.36},{"Dinas Pekerjaan Umum dan Penataan Ruang":4977731574172.72},{"Dinas PU Pengairan":26300000},{"Dinas Perumahan dan Kawasan Permukiman":45055322473},{"Dinas Perhubungan":33080888009.36},{"Dinas Kesehatan":169493282147.73},{"Rumah Sakit Umum Daerah Caruban":219263313973.84},{"Dinas Pengendalian Penduduk dan Keluarga Berencana, Pemberdayaan Perempuan dan Perlindungan Anak":12822979368},{"Rumah Sakit Umum Daerah Dolopo":185066568209.44},{"Dinas Pendidikan dan Kebudayaan":460886604092.12},{"Dinas Perpustakaan Dan Kearsipan":6382075940.8},{"Dinas Pemberdayaan Masyarakat dan Desa":10049243617},{"Badan Penanggulangan Bencana Daerah":5630254171.6},{"Dinas Sosial":2722446535},{"Dinas Kependudukan dan Pencatatan Sipil":6814291888},{"Dinas Tenaga Kerja":6983053696},{"Dinas Pertanian dan Perikanan":54486271324.33},{"Dinas Peternakan dan Perikanan":908473000},{"Dinas Kehutanan dan Perkebunan":7968956160},{"Dinas Ketahanan Pangan dan Peternakan":5019299363},{"Dinas Perdagangan, Koperasi dan Usaha Mikro":151083380685.72},{"Badan Pendapatan Daerah":19533430286.26},{"Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu":3980018145.28},{"Inspektorat":10242875388.4},{"Badan Perencanaan Pembangunan Daerah":13303194585},{"Dinas Lingkungan Hidup":70411844199.63},{"Dinas Kebersihan dan Pertamanan":603432876},{"Dinas Pariwisata, Pemuda dan Olah Raga":58599222821.94},{"Badan Kesatuan Bangsa dan Politik Dalam Negeri":9659918545.5},{"Satuan Polisi Pamong Praja":16156223032},{"Badan Kepegawaian Daerah":11634069236.98},{"Badan Penelitian dan Pengembangan":0},{"Badan Pengelolaan Keuangan dan Aset Daerah":138236652069.46},{"Dinas Komunikasi dan Informatika":12809926368},{"Kecamatan Madiun":2564778114.5},{"Kecamatan Jiwan":3398443793.5},{"Kecamatan Sawahan":22785463749.5},{"Kecamatan Balerejo":6072842586.5},{"Kecamatan Wungu":2338305564.5},{"Kecamatan Kare":3884950742.5},{"Kecamatan Gemarang":3565502079.5},{"Kecamatan Mejayan":4584678465.5},{"Kecamatan Wonoasri":2533806776.5},{"Kecamatan Pilangkenceng":2261066152.5},{"Kecamatan Saradan":3702396919.5},{"Kecamatan Geger":3781051881.5},{"Kecamatan Dolopo":2887713310.5},{"Kecamatan Kebonsari":3866475817.5},{"Kecamatan Dagangan":2248531902.5},{"Kelurahan Nglames":2636444559},{"Kelurahan Munggut":2993320946},{"Kelurahan Wungu":4172720906.68},{"Kelurahan Bangunsari Mejayan":2975986977},{"Kelurahan Krajan":3012805603},{"Kelurahan Pandean":4034929177.27},{"Kelurahan Bangunsari Dolopo":6096745771},{"Kelurahan Mlilir":5345505710}];
var new_data = [];
var labels = [];
data_skpd.map(function(b, i){
	if(i < 30){ return; }
	var data = {};
	for(var n in b){
		labels.push(n.substring(0, 50));
		new_data.push(b[n]);
	}
});
console.log('new_data', new_data);
window.pieChart2 = new Chart(document.getElementById('chart_per_unit'), {
    type: 'line',
    data: {
    	labels: labels,
        datasets: [
            {
                label: 'Nilai Aset',
                data: new_data,
                backgroundColor: [
                    'rgba(255, 99, 132, 1)'
                ]
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    font: {
                        size: 16
                    }
                }
            },
            tooltip: {
            	bodyFont: {
            		size: 16
            	},
            	backgroundColor: 'rgba(0, 0, 0, 0.8)',
            	boxPadding: 5
            },
        },
        animation: {
		  	onProgress: function() {
			    const ctx = this.ctx;
			    ctx.textAlign = 'center';
			    ctx.textBaseline = 'bottom';

			    let dataSum = 0;
			    if(this._sortedMetasets.length > 0 && this._sortedMetasets[0].data.length > 0) {
			      	const dataset = this._sortedMetasets[0].data[0].$context.dataset;
			      	dataSum = dataset.data.reduce((p, c) => p + c, 0);
			    }
			    if(dataSum <= 0) return;

			    this._sortedMetasets.forEach(meta => {
			      	meta.data.forEach(metaData => {
				        const dataset = metaData.$context.dataset;
				        const datasetIndex = metaData.$context.dataIndex;
				        const value = dataset.data[datasetIndex];
				        const percent = (Math.round(value / dataSum * 1000) / 10) + '%';
				        const mid_radius = metaData.innerRadius + (metaData.outerRadius - metaData.innerRadius) * 0.7;
				        const start_angle = metaData.startAngle;
				        const end_angle = metaData.endAngle;
				        if(start_angle === end_angle) return; // hidden
				        const mid_angle = start_angle + (end_angle - start_angle) / 2;

				        const x = mid_radius * Math.cos(mid_angle);
				        const y = mid_radius * Math.sin(mid_angle);

				        ctx.fillStyle = '#fff';
				        ctx.fillText(formatRupiah(value), metaData.x + x, metaData.y + y);
				        ctx.fillText(percent, metaData.x + x, metaData.y + y + 20);
			      	});
			    });
		  	}
		}
    }
});