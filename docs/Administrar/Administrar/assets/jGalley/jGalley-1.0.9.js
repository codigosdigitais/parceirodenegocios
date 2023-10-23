(function($) {
    $.jGalley = function(element, options) {
        var plugin = this;
        plugin.settings = {}
        var $element = $(element),
             element = element;

        var defaults = {
            efeito:			"random",
			botaoVoltar:	false,
			botaoAvancar:	false,
			tempoDoEfeito:	1000,
			tempoDaPausa:	5000,
			linhas:			10,
			colunas:		20,
			overflow:		"hidden",
			mostrarLogsEm:	false,
			criarNavegacao:	true,
            fnAposCarregar:	function(){},
            fnAposEfeito:	function(){},
            fnAntesDoEfeito:function(){}
        }
		var vars = {
			lastEffectUsed:new Array(),	
			allEffects:new Array("apagar","paraCima","paraBaixo","paraDireita","paraEsquerda","piscar","muitasFatias"),
			//"pixelizar","blocos","fatiasParaCima","fatiasParaCimaMais","fatiasParaDireita",
			//"fatiasParaDireitaMais","giroVertical","giroVerticalMaisDireita","giroHorizontal"
			elements: new Array(),
			currentElement: 0,
			playingNow: false,
			manualPlay: false,
			rows: new Array(),
			firstPlay: true
		}

        plugin.init = function() {
            plugin.settings = $.extend({}, defaults, options);
			if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("Iniciando plugin<br>");
            functions.initialize();			
        }
		
		var functions = {
			initialize: function() {
				functions.addStyle();
				functions.populateElementsArray();
				$(element).find("img").css("display","none");
				$.when(  $(element).append("<div class='jGalley-absolute'></div>")  ).then(function(){
					if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("Criando barra de carregamento<br>");
					createLoading.start();
					functions.setAbsoluteDivSize();
					functions.loadImagesAndStartPlugin();
				});
			},
			loadImagesAndStartPlugin: function(){
				if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("Carregando imagens<br>");
				var i = 0;
				$(element).find("img:first").load(function(e) {
					functions.setAbsoluteDivSize();
					i++;
					if (i == 1) {
						if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("Carregada primeira imagem, iniciando autoPlay<br>");
						$(element).find(".jGalley-absolute").append( $(element).children().not(".jGalley-absolute") );
						$(this).fadeIn(500).after(function() {
							functions.autoPlay('next');
						});
					}
				});
				var aux = 0;
				$(element).find("img").one("load",function(){
					aux++;
					if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("Carregada imagem: "+aux+"<br>");
					if (aux == $(element).find("img").length){
						if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("Todas as imagens carregadas<br>");
						$(element).find(".jGalley-absolute").animate({"opacity":1});
						createLoading.stop();
						functions.addNavBar();
						functions.setClickers();
						plugin.settings.fnAposCarregar.call(this);
					}
						
				}).each(function() {
					if(this.complete) $(this).trigger("load");
				});
			},
			addNavBar: function(){
				if (plugin.settings.criarNavegacao){
					if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("Inserindo barra de navegação<br>");
					var navBar = "<div class='jNavBar'>";
					for (var i=0; i < vars.elements.length; i++){
						var classs = ""; if (i == vars.currentElement) classs = " jIC";
						navBar+= "<div class='jI"+ classs +"'></div>";
					}
					navBar+="</div>";
					$(element).find(".jGalley-absolute").append(navBar).after(function(){
						var jAbsolute = $(element).find(".jGalley-absolute");
						$(element).find(".jI").each(function(index, element) {
							$(this).click(function(e) {
                                functions.manualPlay( index );
                            });
                        });
					});
				}
			},
			populateElementsArray: function(){
				$(element).find("img").each(function(index, e) {
					vars.elements[index] = $(this);
                });
			},
			setClickers: function(){
				if (plugin.settings.botaoVoltar)
					$(plugin.settings.botaoVoltar).click(function(){
						functions.manualPlay('prev');
					});
				
				if (plugin.settings.botaoAvancar)
					$(plugin.settings.botaoAvancar).click(function(){
						functions.manualPlay('next');
					});
			},
			setAbsoluteDivSize: function(){
				var jAbsoluteSize = (plugin.settings.criarNavegacao) ? $(element).height() + 20 : $(element).height();
				$(element).find(".jGalley-absolute").css({
					"width":  $(element).width(),
					"overflow": plugin.settings.overflow
				}).animate({
					"min-height": "20px",
					"height": jAbsoluteSize
				});
			},
			effectSelector: function(prevNext){
				if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("Seletor de efeitos... <br>");
				var effect = ((plugin.settings.efeito != "random") 
					? plugin.settings.efeito 
					: functions.selectRandomEffect(prevNext));
				if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("#Efeito: " + effect + "<br>");
				effects[effect](prevNext);
			},
			selectRandomEffect: function(prevNext){
				if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("#Selecionar randômico... <br>");
				if ((prevNext == "prev" || prevNext < vars.currentElement )&& vars.lastEffectUsed.length > 0){
					lastEffectUsed = vars.lastEffectUsed[vars.lastEffectUsed.length -1];
					vars.lastEffectUsed.splice(vars.lastEffectUsed.length -1,1);
				}
				else {
					var allEffects      = vars.allEffects;
					var lastEffectUsed  = vars.lastEffectUsed[vars.lastEffectUsed.length -1];
					var auxBreak		= 0;
					
					while (vars.lastEffectUsed.indexOf(lastEffectUsed) >= 0 || vars.lastEffectUsed.length == 0){
						auxBreak++;
						if (auxBreak == 10) return lastEffectUsed;
						var n = Math.floor((Math.random()*allEffects.length));
						lastEffectUsed = allEffects[n];
						if (vars.lastEffectUsed.length == 0) break;
					}
					vars.lastEffectUsed.push(lastEffectUsed);
					if (vars.lastEffectUsed.length > (allEffects.length * 0.6))
						vars.lastEffectUsed.splice(0,1);
				}
				return lastEffectUsed;
			},
			getNextImage: function(prevNext){
				if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("Buscar próxima imagem... <br>");
				var current = vars.currentElement;
				if (prevNext == "next" || prevNext == "prev"){
					while (true) {
						var next = (prevNext == "next") ? (Number(current)+1) : (Number(current)-1);
						if (next == vars.elements.length) next = 0;
						else if (next < 0) next = (vars.elements.length -1);
						current = next;
						
						if (next == vars.currentElement) {
							if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("#Nada carregado ainda<br>");
							vars.playingNow = false;
							functions.autoPlay("next");
							return 'null';
						}
						
						else if ( $(element).find("img:eq("+next+")")[0].complete ) {
							if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("#"+ $(element).find("img:eq("+next+")").attr('src') +"<br>");
							vars.currentElement = next;
							$(element).find(".jI").removeClass("jIC");
							$(element).find(".jI:eq("+vars.currentElement+")").addClass("jIC");
							return next;
						}
					}
				}
				else {
					if (prevNext != current){
						if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("#"+ $(element).find("img:eq("+vars.currentElement+")").attr('src') +"<br>");
						vars.currentElement = prevNext;
						$(element).find(".jI").removeClass("jIC");
						$(element).find(".jI:eq("+vars.currentElement+")").addClass("jIC");
						return prevNext;
					}
					else {
						if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("#Mesma imagem<br>");
						vars.playingNow = false;
						functions.autoPlay("next");
					}
				}
				return 'null';
			},
			autoPlay: function(prevNext){
				if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("#Troca automática('"+prevNext+"') em "+plugin.settings.tempoDaPausa+"ms<br>");
				if (!vars.firstPlay) plugin.settings.fnAposEfeito.call(this);
				else vars.firstPlay = false;
				
				var f = function(){ effects.playEffect(prevNext,false); }
					setTimeout(f, plugin.settings.tempoDaPausa);
			},
			manualPlay: function(prevNext){
				if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("Troca Manual('"+prevNext+"'): autorizado: "+!vars.playingNow+" <br>");
				if (!vars.playingNow)
					effects.playEffect(prevNext,true);
			},
			addStyle: function(){
				if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("Adicionando <style> para jGalley<br>");
				if (!$("body").hasClass('stylized')){
					$("head:first").append('<style>@charset "utf-8";.jGalley-absolute{position:absolute;background-color:#FFF;padding:0;opacity:0.5;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";filter:alpha(opacity=50);}.jGalley-absolute .jgl{position:absolute;left:50%;top:50%;z-index:999999;}.jGalley-absolute .jgl2{position:absolute;width:100px;height:20px;left:-50px;top:-10px;text-align:center;}.jGalley-absolute .jgl2 div{width:1px;height:12px;margin:0 2px;display:inline-block;border:1px solid #121212;background-color:rgb(214,214,214);}.jGalley-absolute img{position:absolute;z-index:100;}.jGalley-absolute .jS{background-color:#CCC;position:absolute;z-index:98;}.jNavBar{position:absolute;background-color:#FFF;text-align:center;width:100%;height:20px;left:0;bottom:0;z-index:100;}.jI{display:inline-table;margin:2px 2px 0 2px;border-color:#7B7B7B;font-size:9px;border-style:solid;border-radius:50%;border-width:1px;width:13px;height:13px;padding:0 1px 1px 0;box-shadow:#CCC 0 0 1px 1px;cursor:pointer;}.jIC{background-color:#617BA8;}</style>');
					$("body").addClass('stylized');
				}
			}
		}
		var effects = {
			playEffect: function(prevNext,manualPlay){
				if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("playEffect... <br>");
				
				if (!vars.playingNow && (!vars.manualPlay || manualPlay)){
					if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("playEffect iniciando<br>");
					vars.playingNow = true;
					plugin.settings.fnAntesDoEfeito.call(this);
					functions.effectSelector(prevNext);
				}
				else if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("ignorado playEffect... alterando manualPlay para false<br>");
				vars.manualPlay = (manualPlay) ? true : false;
			},
			apagar: function(prevNext){
				next = functions.getNextImage(prevNext);
				if (next != 'null') {
					$( element ).find("img").fadeOut(plugin.settings.tempoDoEfeito);
					$( element ).find("img:eq("+next+")").fadeIn(plugin.settings.tempoDoEfeito,function(){
						vars.playingNow = false;
						functions.autoPlay("next");
					});
				}
			},
			paraCima: function(prevNext,signal){
				if (typeof(signal) == "undefined"){
					signal1 = (prevNext == "next") ? "-=" : "+=";
					signal2 = (prevNext == "next") ? "+=" : "-=";
				}
				else{
					signal1 = (signal == "-=") ? "-=" : "+=";
					signal2 = (signal == "-=") ? "+=" : "-=";
				}
				var currentElement = vars.currentElement;
				next = functions.getNextImage(prevNext);
				if (next != 'null') {
					var elem1 = $( element ).find("img:eq("+currentElement+")");
					var elem2 = $( element ).find("img:eq("+next+")");
					
					$( elem1 ).animate({ top: signal1+ $( elem1 ).height(), opacity:0 },plugin.settings.tempoDoEfeito)
							  .fadeOut()
							  .animate({ top: signal2+ $( elem1 ).height(), opacity:1 });
							  
					$( elem2 ).animate({ top: signal2+ $( elem2 ).height(), opacity:0},1).fadeIn()
							  .animate({ top: signal1+ $( elem2 ).height(), opacity:1 },plugin.settings.tempoDoEfeito,function(){
								  vars.playingNow = false;
								  functions.autoPlay("next");
					});
				}
			},
			paraBaixo: function(prevNext){
				var signal = (prevNext == "next") ? "+=" : "-=";
				effects.paraCima(prevNext,signal);
			},
			paraEsquerda: function(prevNext,signal){
				if (typeof(signal) == "undefined"){
					signal1 = (prevNext == "next") ? "+=" : "-=";
					signal2 = (prevNext == "next") ? "-=" : "+=";
				}
				else{
					signal1 = (signal == "-=") ? "+=" : "-=";
					signal2 = (signal == "-=") ? "-=" : "+=";
				}
				var currentElement = vars.currentElement;
				next = functions.getNextImage(prevNext);
				if (next != 'null') {
					var elem1 = $( element ).find("img:eq("+currentElement+")");
					var elem2 = $( element ).find("img:eq("+next+")");
					
					$( elem1 ).animate({ right: signal1+ $( elem1 ).width(), opacity:0 },plugin.settings.tempoDoEfeito)
							  .fadeOut()
							  .animate({ right: signal2+ $( elem1 ).width(), opacity:1 });
							  
					$( elem2 ).animate({ right: signal2+ $( elem2 ).width(), opacity:0},1).fadeIn()
							  .animate({ right: signal1+ $( elem2 ).width(), opacity:1 },plugin.settings.tempoDoEfeito,function(){
								  vars.playingNow = false;
								  functions.autoPlay("next");
					});
				}
			},
			paraDireita: function(prevNext){
				var signal = (prevNext == "next") ? "+=" : "-=";
				effects.paraEsquerda(prevNext,signal);
			},
			piscar: function(prevNext,signal){
				var currentElement = vars.currentElement;
				next = functions.getNextImage(prevNext);
				if (next != 'null') {
					var elem1 = $( element ).find("img:eq("+currentElement+")");
					var elem2 = $( element ).find("img:eq("+next+")");
					var elem1height = $(elem1).height();
					var elem2height = $(elem2).height();
					
					$( elem2 ).animate({ width: $( elem1 ).width(), height:0, opacity:0.5, top:"+="+ elem1height/2}).fadeIn(1,function(){
						$( elem1 ).animate({ width: $( elem1 ).width(), height:0, opacity:0.5, top:"+="+ elem1height/2 },plugin.settings.tempoDoEfeito /2.8)
								  .fadeOut()
								  .animate({ height: elem1height, opacity:1, top:"-="+ elem1height/2
						});
							  
						$( elem2 ).delay(plugin.settings.tempoDoEfeito /3.5)
								  .animate({  height: elem2height, opacity:1, top:"-="+ elem1height/2 },plugin.settings.tempoDoEfeito /1.4,function(){
									  vars.playingNow = false;
									  functions.autoPlay("next");
						});
					});
							  
				}
			},
			muitasFatias: function(prevNext){
				var currentElement = vars.currentElement;
				next = functions.getNextImage(prevNext);
				if (next != 'null') {
					var elem1 = $( element ).find("img:eq("+currentElement+")");
					var elem2 = $( element ).find("img:eq("+next+")");
					var cols = 3;
					var rows = plugin.settings.colunas;
					
					effectsFunctions.addCols(elem1,cols,rows);
					effectsFunctions.auxmuitasFatias(elem2);
				}
			},
			pixelizar: function(prevNext){
				var currentElement = vars.currentElement;
				next = functions.getNextImage(prevNext);
				if (next != 'null') {
					var elem1 = $( element ).find("img:eq("+currentElement+")");
					var elem2 = $( element ).find("img:eq("+next+")");
					var cols = plugin.settings.linhas;
					var rows = plugin.settings.colunas;
					
					effectsFunctions.addCols(elem1,cols,rows);
					effectsFunctions.auxpixelizar(elem2);
				}
			},
			blocos: function(prevNext){
				var currentElement = vars.currentElement;
				next = functions.getNextImage(prevNext);
				if (next != 'null') {
					var elem1 = $( element ).find("img:eq("+currentElement+")");
					var elem2 = $( element ).find("img:eq("+next+")");
					var cols = plugin.settings.linhas/2;
					var rows = plugin.settings.colunas/2;
					
					effectsFunctions.addCols(elem1,cols,rows);
					effectsFunctions.auxblocos(elem2);
				}
			},
			fatiasParaCima: function(prevNext,type,direction){
				var currentElement = vars.currentElement;
				next = functions.getNextImage(prevNext);
				if (next != 'null') {
					var elem1 = $( element ).find("img:eq("+currentElement+")");
					var elem2 = $( element ).find("img:eq("+next+")");
					
					if (typeof(direction) == "undefined"){
						var cols = (typeof(type) == "undefined" || type == '') ? 1 : plugin.settings.linhas;
						var rows = plugin.settings.colunas;
					}
					else {
						var cols = plugin.settings.linhas;
						var rows = (typeof(type) == "undefined" || type == '') ? 1 : plugin.settings.colunas;
					}
					
					effectsFunctions.addCols(elem1,cols,rows);
					if (typeof(direction) == "undefined")
						effectsFunctions.auxfatiasParaCima(elem2);
					else
						effectsFunctions.auxfatiasParaDireita(elem2);
				}
			},
			giroVertical: function(prevNext,type){
				var currentElement = vars.currentElement;
				next = functions.getNextImage(prevNext);
				if (next != 'null') {
					var elem1 = $( element ).find("img:eq("+currentElement+")");
					var elem2 = $( element ).find("img:eq("+next+")");
					
					var cols = plugin.settings.linhas;
					var rows = (typeof(type) == "undefined" || type == '') ? 1 : plugin.settings.colunas;
					
					effectsFunctions.addCols(elem1,cols,rows);
					effectsFunctions.auxgiroVertical(elem2);
				}
			},
			giroHorizontal: function(prevNext){
				var currentElement = vars.currentElement;
				next = functions.getNextImage(prevNext);
				if (next != 'null') {
					var elem1 = $( element ).find("img:eq("+currentElement+")");
					var elem2 = $( element ).find("img:eq("+next+")");
					var cols = 1;
					var rows = plugin.settings.colunas;
					effectsFunctions.addCols(elem1,cols,rows);
					/* the magic */
					for (var row = 0; row < vars.rows.length; row++){
						var slices 		= effectsFunctions.getSlices(vars.rows[row]);
						for (var col = 0; col < slices.length; col++){
							var reverseCol = (slices.length-1) - col;
								reverseCol = (prevNext == "next") ? col : reverseCol;
							var delay = (plugin.settings.tempoDoEfeito *0.8) +(20*col);
							var width = $( slices[reverseCol] ).width();
							
							$( slices[reverseCol] ).clone().prependTo( $(element).find(".jGalley-absolute") );
							$( slices[reverseCol] ).after(function(){
								$( this ).css({"background-image": "url("+$(elem2).attr('src')+")", "opacity":0,"width":0});
								if (prevNext == "next")
									$( this ).delay(delay).animate({ width: width, "opacity":1 }, plugin.settings.tempoDoEfeito);
								else{
									$( this ).animate({ left: "+="+ width});
									$( this ).delay(delay).animate({ width: width, left: "-="+ width, "opacity":1 }, plugin.settings.tempoDoEfeito);
								}
							});
						}
						if (row == vars.rows.length-1){
							var delayToFinish = (plugin.settings.tempoDoEfeito *0.8) +(20*(slices.length-1));
							var finishing = function(){
								effectsFunctions.finishingEffect();
							}
							setTimeout(finishing,delayToFinish);
						}
					}
				}
			},
			giroVerticalMaisDireita: function(prevNext){
				effects.giroVertical(prevNext,'nice');
			},
			fatiasParaCimaMais: function(prevNext){
				effects.fatiasParaCima(prevNext,'nice');
			},
			fatiasParaDireita: function(prevNext){
				effects.fatiasParaCima(prevNext,'','right');
			},
			fatiasParaDireitaMais: function(prevNext){
				effects.fatiasParaCima(prevNext,'nice','right');
			}
		}
		var effectsFunctions = {
			finishingEffect: function(){
				if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("Finalizando efeito<br>");
				vars.playingNow = false;
				vars.rows = new Array();
				$( element ).find("img:eq("+vars.currentElement+")").fadeIn(plugin.settings.tempoDoEfeito,function(){
					$( element ).find(".jS").remove();
					functions.autoPlay("next");
				});
			},
			auxmuitasFatias: function(nextElement){
				for (var row = 0; row < vars.rows.length; row++){
					var f = function(nextElement,row){
						var slices 		= effectsFunctions.getSlices(vars.rows[row]);
							slices 		= (row%2 == 0) ? slices.reverse() : slices;
						var dir1		= (row%2 == 0) ? "+=" : "-=";
						var dir2		= (row%2 == 0) ? "-=" : "+=";
						var slicesWidth	= $(nextElement).width() / slices.length;
						
						for (var col = 0; col < slices.length; col++){
							var delay = (plugin.settings.tempoDoEfeito/30)*col;
								$( slices[col] ).delay(delay)
									.animate({ "left":	dir1 +"10px"}, plugin.settings.tempoDoEfeito/4)
									.animate({ "width": 0 }, plugin.settings.tempoDoEfeito/8, function(){
										$( this ).css({"background-image": "url("+$(nextElement).attr('src')+")"});
										$( this ).animate({ "left":	dir2 +"10px", "width": slicesWidth+"px" }, plugin.settings.tempoDoEfeito/4);
									});
						}
						//necessary to check when the effect ends
						if (row == vars.rows.length-1){
							var delayToFinish = (plugin.settings.tempoDoEfeito/30)*(slices.length-1);
								delayToFinish+= ((plugin.settings.tempoDoEfeito/4)) + (plugin.settings.tempoDoEfeito/8);
								delayToFinish+= (plugin.settings.tempoDoEfeito/5 * vars.rows.length-1);
							var finishing = function(){ 
								effectsFunctions.finishingEffect();
							}
							setTimeout(finishing,delayToFinish);
						}
						
					}
					var auxf = function(nextElement,row){
						var auxf2 = function(){ f(nextElement,row); }
						setTimeout(auxf2,(plugin.settings.tempoDoEfeito/5 * row));
					}
					
					auxf(nextElement,row);
				}
			},
			auxpixelizar: function(nextElement){
				for (var row = 0; row < vars.rows.length; row++){
					var f = function(nextElement,row){
						var slices 		= effectsFunctions.getSlices(vars.rows[row]);
						
						for (var col = 0; col < slices.length; col++){
							var delay = (plugin.settings.tempoDoEfeito/30)*col;
								$( slices[col] ).delay(delay)
									.animate({ "opacity":	0.8}, plugin.settings.tempoDoEfeito/4, function(){
										$( this ).css({"background-image": "url("+$(nextElement).attr('src')+")"});
										$( this ).animate({ "opacity":	1 }, plugin.settings.tempoDoEfeito/4);
									});
						}
						//necessary to check when the effect ends
						if (row == vars.rows.length-1){
							var delayToFinish = (plugin.settings.tempoDoEfeito/30)*(slices.length-1);
								delayToFinish+= ((plugin.settings.tempoDoEfeito/4)) + (plugin.settings.tempoDoEfeito/4);
							var finishing = function(){
								effectsFunctions.finishingEffect();
							}
							setTimeout(finishing,delayToFinish);
						}
						
					}
					var auxf = function(nextElement,row){
						var auxf2 = function(){ f(nextElement,row); }
						setTimeout(auxf2,(plugin.settings.tempoDoEfeito/12 * row));
					}
					
					auxf(nextElement,row);
				}
			},
			auxfatiasParaCima: function(nextElement){
				var effectTime = Number(plugin.settings.tempoDoEfeito);
				for (var row = 0; row < vars.rows.length; row++){
					var f = function(nextElement,row){
						var slices 		= effectsFunctions.getSlices(vars.rows[row]);
						var jAbHeight 	= $(element).find(".jGalley-absolute").height();
						
						for (var col = 0; col < slices.length; col++){
							var delay = (effectTime/15)*col;
							var height=	$( slices[col] ).height();
							
							$( slices[col] ).delay(delay)
								.animate({ "top": "-=" + (jAbHeight +100) }, (effectTime *1.5)).fadeOut();
								
							$( slices[col] ).clone().prependTo( $(element).find(".jGalley-absolute") ).after(function(){
								$( this ).css({ "background-image": "url("+$(nextElement).attr('src')+")","opacity": 0})
										 .animate({ "top": "+=" + (jAbHeight + height +100)}, delay)
										 .css({"opacity": 1})
										 .animate({ "top": "-=" + (jAbHeight + height +100)}, (effectTime *1.5));
							});
						}
						//necessary to check when the effect ends
						if (row == vars.rows.length-1){
							var delayToFinish = (effectTime/30)*(slices.length-1);
								delayToFinish+= ((effectTime/4)) + (effectTime);
							var finishing = function(){
								effectsFunctions.finishingEffect();
							}
							setTimeout(finishing,delayToFinish);
						}
						
					}
					var auxf = function(nextElement,row){
						var auxf2 = function(){ f(nextElement,row); }
						setTimeout(auxf2,(effectTime/12 * row));
					}
					
					auxf(nextElement,row);
				}
			},
			auxfatiasParaDireita: function(nextElement){
				var effectTime = Number(plugin.settings.tempoDoEfeito);
				for (var row = 0; row < vars.rows.length; row++){
					var f = function(nextElement,row){
						var slices 		= effectsFunctions.getSlices(vars.rows[row]);
						var jAbWidth 	= $(element).find(".jGalley-absolute").width();
						
						for (var col = 0; col < slices.length; col++){
							var delay = ((effectTime/15) * slices.length) - ((effectTime/15)*col);
							var width=	$( slices[col] ).width();
							
							$( slices[col] ).delay(delay)
								.animate({ "left": "+=" + (jAbWidth +100) }, (effectTime *1.5)).fadeOut();
							
							$( slices[col] ).clone().prependTo( $(element).find(".jGalley-absolute") ).after(function(){
								$( this ).css({ "background-image": "url("+$(nextElement).attr('src')+")","opacity": 0})
										 .animate({ "left": "+=" + (jAbWidth + width +100)}, delay)
										 .css({"opacity": 1})
										 .animate({ "left": "-=" + (jAbWidth + width +100)}, (effectTime *1.5));
							});
						}
						//necessary to check when the effect ends
						if (row == vars.rows.length-1){
							var delayToFinish = (effectTime/30)*(slices.length-1);
								delayToFinish+= ((effectTime/4)) + (effectTime);
							var finishing = function(){
								effectsFunctions.finishingEffect();
							}
							setTimeout(finishing,delayToFinish);
						}
						
					}
					var auxf = function(nextElement,row){
						var auxf2 = function(){ f(nextElement,row); }
						setTimeout(auxf2,(effectTime/12 * row));
					}
					
					auxf(nextElement,row);
				}
			},
			auxgiroVertical: function(nextElement){
				for (var row = 0; row < vars.rows.length; row++){
					var f = function(nextElement,row){
						var slices 		= effectsFunctions.getSlices(vars.rows[row]);
							slices		= slices.reverse();
						var jAbWidth 	= $(element).find(".jGalley-absolute").width();
						for (var col = 0; col < slices.length; col++){
							var delay = ((plugin.settings.tempoDoEfeito/15) * slices.length) - ((plugin.settings.tempoDoEfeito/15)*col);
							var width=	$( slices[col] ).width();
							
							$( slices[col] ).delay(delay)
								.animate({ "right": "-=" + (jAbWidth +100) }, (plugin.settings.tempoDoEfeito *1.5)).fadeOut();
								
							$( slices[col] ).clone().prependTo( $(element).find(".jGalley-absolute") ).after(function(){
								$( this ).css({ "background-image": "url("+$(nextElement).attr('src')+")","opacity": 0})
										 .animate({ "right": "+=" + (jAbWidth + width +100)}, delay)
										 .css({"opacity": 1})
										 .animate({ "right": "-=" + (jAbWidth + width +100)}, (plugin.settings.tempoDoEfeito *1.5));
							});
						}
						//necessary to check when the effect ends
						if (row == vars.rows.length-1){
							var delayToFinish = (plugin.settings.tempoDoEfeito/30)*(slices.length-1);
								delayToFinish+= ((plugin.settings.tempoDoEfeito/4)) + (plugin.settings.tempoDoEfeito);
							var finishing = function(){
								effectsFunctions.finishingEffect();
							}
							setTimeout(finishing,delayToFinish);
						}
						
					}
					var auxf = function(nextElement,row){
						var auxf2 = function(){ f(nextElement,row); }
						setTimeout(auxf2,(plugin.settings.tempoDoEfeito/12 * row));
					}
					
					auxf(nextElement,row);
				}
			},
			auxblocos: function(nextElement){
				for (var row = 0; row < vars.rows.length; row++){
					var slices 		= effectsFunctions.getSlices(vars.rows[row]);
					
					for (var col = 0; col < slices.length; col++){
						var delay = (Math.floor(Math.random() * (plugin.settings.tempoDoEfeito *1.5))+1);
						$( slices[col] ).clone().prependTo( $(element).find(".jGalley-absolute") );
						$( slices[col] ).css({"background-image": "url("+$(nextElement).attr('src')+")","z-index":101,"opacity":0})
										.delay(delay).animate({ "opacity":	1 }, plugin.settings.tempoDoEfeito);
					}
					//necessary to check when the effect ends
					if (row == vars.rows.length-1){
						var delayToFinish = (plugin.settings.tempoDoEfeito/30)*(slices.length-1);
							delayToFinish+= ((plugin.settings.tempoDoEfeito/4)) + (plugin.settings.tempoDoEfeito/4);
						var finishing = function(){
							effectsFunctions.finishingEffect();
						}
						setTimeout(finishing,delayToFinish);
					}
				}
			},
			getSlices: function(elements){
				var slices = new Array();
				$(element).find(elements).each(function(index, e) {
					slices.push(e);
				});
				return slices;
			},
			addCols: function(currentElement,cols,rows){
				var height = $(currentElement).height() / cols;
				var last = false;
				for (var col = 0; col < cols; col++){
					vars.rows.push(".jC"+col);
					var top = ( ($(currentElement).height() / cols) *col );
					if (col == (cols -1)) last = true;
					effectsFunctions.addRows(currentElement,col,rows,top,height,last);
				}
			},
			addRows: function(currentElement,col,rows,top,height,last){
				var sliceSize = $(currentElement).width() / rows;
				for (var i = 0; i < rows; i++){
					var sl = "<div class='jS jC"+col+"' style='"+
								 "left:"	+(sliceSize*i)+"px;"+
								 "top:"		+top+"px;"+
								 "width:"	+sliceSize+"px;"+
								 "height:"	+height+"px;"+
								 "background:url("+ $(currentElement).attr("src") +") no-repeat -"+ sliceSize*i +"px -"+top+"px;"+ 
							 "'></div>";
					$(element).find(".jGalley-absolute").append(sl);
					
					if (last && i == (rows -1)){
						$(currentElement).fadeOut(1);
					}
				}
			}
		}

        var createLoading = {
			start: function() {
				$.when( $(element).find(".jGalley-absolute").append("<div class='jgl'><div class='jgl2'></div></div>") ).then(function() {
					for (var aux = 1; aux <= 10; aux++){
						$(element).find(".jgl2").append("<div></div>");
					}
				}).then(function() {
					$(element).find(".jgl2 div").css("opacity",0).each(function(index, element) {
						var f = function(){createLoading.show(index, element)}
						setTimeout(f,index * 50);
					});
				});
			},
			show: function(index, element){
				$(element).animate({ "opacity": 1 },300).after(function(){
					var f = function(){createLoading.hide(index, element)}
					setTimeout(f,200);
				});
			},
			hide: function(index, element){
				$(element).animate({ "opacity": 0 },300).after(function(){
					var f = function(){createLoading.show(index, element)}
					setTimeout(f,800);
				});
			},
			stop: function() {
				$(element).find(".jgl").remove();
			}
        }
		
        plugin.changeAttr = function(attr,value) {
			if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("- Alterar atributo &quot;"+attr+"&quot; para: " + value +"<br>");
			
			if (!vars.playingNow){
				var change = true;
				if (attr == "botaoVoltar" && value != "" && value != "false" && value != plugin.settings.botaoVoltar){
					$(plugin.settings.botaoVoltar).unbind("click");
					$(value).click(function(){ functions.manualPlay('prev'); });
					plugin.settings[attr] = value;
				}
				else if (attr == "botaoAvancar" && value != "" && value != "false" && value != plugin.settings.botaoAvancar){
					$(plugin.settings.botaoAvancar).unbind("click");
					$(value).click(function(){ functions.manualPlay('next'); });
					plugin.settings[attr] = value;
				}
				else if (attr == "overflow" && value != plugin.settings.overflow){
					$(element).find(".jGalley-absolute").css("overflow", value);
					plugin.settings[attr] = value;
				}
				else if (attr == "criarNavegacao" && value == "true" && $(element).find(".jNavBar").length == 0){
					functions.addNavBar();
				}
				else if (attr == "criarNavegacao" && value == "false" && $(element).find(".jNavBar").length > 0){
					$(element).find(".jNavBar").remove();
				}
				else if (attr == "mostrarLogsEm" && value != plugin.settings.mostrarLogsEm){
					plugin.settings.mostrarLogsEm = (value == "false" || value == "") ? false : value;
					plugin.settings[attr] = value;
				}
				
				else if (typeof(plugin.settings[attr]) == "number" && Number(value) != plugin.settings[attr]){
					value = Number(value);
					plugin.settings[attr] = Number(value);
				}
					
				else if (typeof(plugin.settings[attr]) == "string" && value != plugin.settings[attr]){
					plugin.settings[attr] = value;
				}
				
				else change = false;
				
				if (change){ if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("@Alterado &quot;"+attr+"&quot; para: " + plugin.settings[attr] +"<br>");}
				else{ if (plugin.settings.mostrarLogsEm) $(plugin.settings.mostrarLogsEm).prepend("@@NÃO necessário &quot;"+attr+"&quot; para: " + plugin.settings[attr] +"<br>");}
					
			}
			
			else{
				var f = function(){ plugin.changeAttr(attr,value); }
				setTimeout(f,300);
			}
        }
		
        plugin.init();
}

    $.fn.jGalley = function(options) {
        return this.each(function() {
            if (undefined == $(this).data('jGalley')) {
                var plugin = new $.jGalley(this, options);
                $(this).data('jGalley', plugin);
            }
        });
    }

})(jQuery);