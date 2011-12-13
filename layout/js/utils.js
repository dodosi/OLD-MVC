/*
 * @author Salve - Alexsandro
 * prototipos de funcoes comuns do site
 */

var utils = {

    Carrossel : 
    {
	settings : {},
	
	currentPic  : 0,
	totalPics   : 0,
	
	optDefault  :  {
	    parent	: '#gallery',
	    picWidth	:'',
	    numberPicShow   : 1,
	    classMask	: '.mask',
	    classRow	: '.row',
	    classItem	: 'div.item',
	    btnPrevius	: '.prev',
	    btnNext : '.next',
	    opacity : false,
	},
	
	apply : function(options)
	{
		utils.Carrossel.settings =  $.extend( {}, utils.Carrossel.optDefault, options );
		
		var step	= utils.Carrossel.settings.picWidth * utils.Carrossel.settings.numberPicShow;
		var btnPrevius 	= utils.Carrossel.settings.btnPrevius;
		var btnNext 	= utils.Carrossel.settings.btnNext;
		var classRow 	= utils.Carrossel.settings.classRow;
		var parent	= utils.Carrossel.settings.parent;
		var classItem	= utils.Carrossel.settings.classItem;

		totalPics 	= jQuery(utils.Carrossel.settings.classRow + ' '+utils.Carrossel.settings.classItem,parent).length;
		rowWidth 	= jQuery(utils.Carrossel.settings.classRow,parent).width() * totalPics;
		var opacity     = utils.Carrossel.settings.opacity;

		opacity ? jQuery(classItem,parent).hide().filter(':first').show() : '';

		jQuery(utils.Carrossel.settings.classRow,parent).width(rowWidth);

		//LISTENER BTN ANTERIOR
		jQuery(btnPrevius,parent).click(utils.Carrossel.settings.previus);

		//LISTENER BTN PROXIMO
		jQuery(btnNext,parent).click(utils.Carrossel.next);

	},
	
	//VOLTA UM ITEM
	previus : function(){
		utils.Carrossel.currentPic--;
		if(utils.Carrossel.currentPic >= 0)
		{
			jQuery(classRow,parent).animate({left: '+='+step}, 1000) ;
			if(opacity)
			{
			    jQuery(classItem,parent).eq(utils.Carrossel.currentPic + 1).fadeOut(1000);
			    jQuery(classItem,parent).eq(utils.Carrossel.currentPic).fadeIn(100);
			}
		}else{
			utils.Carrossel.currentPic = 0;
		} 	
		if (utils.Carrossel.currentPic <= 0) {
			jQuery(this).animate({
				opacity: 0.3
			}, 100).addClass('disabled');
		}
		jQuery(btnNext,parent).css('opacity','1').removeClass('disabled');	
		return false;
	},
	
	//ADIANA UM ITEM
	next : function(){
	    utils.Carrossel.currentPic++;
	    if(utils.Carrossel.currentPic < totalPics)
	    {
		    jQuery(classRow,parent).animate({left: '-='+step},1000) ;
		    if(opacity)
		    {
			jQuery(classItem,parent).eq(utils.Carrossel.currentPic -1).fadeOut(1000)
			jQuery(classItem,parent).eq(utils.Carrossel.currentPic).fadeIn(1000)
		    }
	    }
	    else
	    {
		    utils.Carrossel.currentPic = totalPics -1;
	    }
	    if (utils.Carrossel.currentPic >= totalPics -1)
		    jQuery(this).animate({opacity: 0.3}, 100).addClass('disabled')
	    jQuery(btnPrevius,parent).css('opacity','1').removeClass('disabled');

	    return false;
	}
    }, //FIM CARROSSEL

    //FUNÇÃO DE ABAS GENERICA PARA O SITE
    Aba : {

	settings : {},

	optDefault : {
	    cssClassTabSelected	    : 'selected',
	    tabSelector		    : '.aba a',
	    tabSelected		    : '',
	    tabContent		    : '.conteudoTabs div'
	},

	apply : function(options){
	    util.Aba.settings =  $.extend( {}, util.Aba.optDefault, options );
	    $(util.Aba.settings.tabContent).hide();

	    $(util.Aba.settings.tabSelector).click(function(e)
	    {
		e.preventDefault();
		$(util.Aba.settings.tabContent).hide();
		$(util.Aba.settings.tabContent).filter(this.hash).show();
		$(util.Aba.settings.tabSelector).removeClass(util.Aba.settings.cssClassTabSelected);
		$(this).addClass(util.Aba.settings.cssClassTabSelected);
	    }).filter(':first').click()
	}
    }//FIM ABA GENERICA

};


utils.carrossel.apply({nome:"alexsandro pereira"});

