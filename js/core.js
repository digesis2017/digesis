
var sn ={}

 sn.utils = {
    eventBind: function(obj){
      var stoped = true, trigger, param, $element;
      if (!obj.element.jquery){
        stoped = obj.event.stopPropagation ? true : false;
        if (obj.event.stopPropagation) obj.event.stopPropagation();
        else {
          stoped = false;
          if (obj.event.cancelBubble) obj.event.cancelBubble = true;
        }
        if (obj.event.preventDefault) obj.event.preventDefault();
        else  obj.event.returnValue = false;

        $element = $(obj.element);
        if (typeof obj.callback == "function") param = obj.callback({element: $element, mom: $element});
        new sn[obj.ui](param.mom);
        if (stoped) {
          trigger = param.element.data('event')||'click.libui';
          param.element.trigger(trigger);
        };
        return true
      }
      return false;
    },
     round:function(number,decimal){
      decimal = parseFloat(decimal?decimal:2)+1;
      decimal = parseFloat('10000'.substr(0,decimal));
      return Math.round(number*decimal)/decimal
    },
    preventDefault: function(e){
      if (e.preventDefault) e.preventDefault();
      else  e.returnValue = false;
    }
  };
  sn.mem = [];
  sn.dropdown = function(element, event){
    var $element = element;
    if (sn.utils.eventBind({element:element, event:event, ui:"dropdown", callback:function(obj){
      obj.element = obj.element.removeAttr('onclick').children('.ui-caption');
      return obj;
    }})) return false;
    $element.children('.ui-caption').on('click.libui',function(e){
      e.preventDefault();
      if ($element.hasClass('ui-open'))  {
        $element.removeClass('ui-open');
        sn.mem['dropdown'] = null;
      }else {
        if (sn.mem['dropdown'])  sn.mem['dropdown'].trigger('click.libui');
        $element.addClass('ui-open');
        sn.mem['dropdown'] = $(this);
      }
    });

    if (($element.data('type')||'select') == 'select'){
      $('.ui-list li:not(.ui-divider) > a',$element).on('click.libui',function(e){
        e.preventDefault();
        var $el = $(this),ps;
        if (!$el.parent().is('.ui-disabled')) $el.closest('.ui-dropdown').find('.ui-caption span').html( $el.html());
        $element.children('.ui-caption').trigger('click.libui');
        $('input[type=hidden]',$element).val($el.data('value')).trigger('change');
        if (ps = $element.data('panels')){ $('#'+ps).children('div').hide().filter($el.attr('href')).show()};
      });
    }
  }

  sn.redirect = function(t){
    var $t = $(t);

    window.location.href = $t.val();

  }

  sn.more = function (t, event) {

    sn.utils.preventDefault(event);
     
    var $t = $(t), $target = $($t.data('target')), url = $t.data('url'), page = $t.data('page')|| 1;
    if($t.data('loading')) return;


    $t.data('loading', true);

      $.get(url, {page: page}, function(data){
          $target.append($(data.html).fadeIn());

          $t.data('page', data.nextPage);
          if(data.nextPage == 0 || data.nextPage == null) $t.remove();
          $t.data('loading', false);
          
      });



    
  }


  sn.orbit = function($element){
    $element = $($element);
    if ($element.length<1 ||$element.hasClass('orbit-ed')) return;
    var $arrows = $element.find('.ui-arrows'),
      $pager = $element.find('.ui-pager'),
      $inner = $element.find('.ui-inner'),
      $items = $inner.children('.ui-item'),
      $thumb = $element.find('.ui-thumbs'),
      itemsLength = $items.length,
      sizes,
      currentSize,
      page = $element.data('page') ? ($element.data('page') -1) : 0,
      innerWidthIni,
      itemMarginIni,
      itemXPageIni,
      pages,
      interval = ($element.data('interval')||0)*1,
      timer,
      caption = $element.data('caption') ? $($element.data('caption')) : 0,
      sizesAuto = $element.data('size')=='auto',
      carrusel = $element.data('carrusel') == false ? 0 : 1,
      heightAuto = $element.data('height')=='auto';
      //async  = $element.data('async');

    if (heightAuto) $element.on('heightAuto',function(){ slide()});
    if (!sizesAuto) {
      sizes = $element.data('size')?$element.data('size').replace(/:([\w\.]*)/g,':[$1]').replace(/x/g,','):'3020:[1,100,0]';
      sizes = eval('[{'+sizes+'}]')[0];
    }

    function slide(){
      var move, dif, widthParent, selIni, selFin, selHeight;
      if (sizesAuto){
        widthParent = $inner.parent().width();
        move = (page*widthParent);
        dif = (move+widthParent - innerWidthIni);
        if (dif>0) move -= dif ;
        $inner.css({'left':(move*-1)});
      }else{
        if (heightAuto){
          selIni = sizes[currentSize][0]*page;
          selFin = selIni+sizes[currentSize][0];
          if (itemsLength<selFin) selIni -= selFin-itemsLength;
          $items.slice( selIni, selFin).each(function(){
            selHeight = (selHeight>$(this).outerHeight(true)) ? selHeight : $(this).outerHeight(true);
          });
        }else selHeight='auto';
        move = (page*100);
        dif = (move+100 - innerWidthIni);
        if (dif>0) move -= dif + (itemMarginIni/itemXPageIni);
        move += (itemMarginIni * page);
        $inner.css({height:selHeight, 'left':(move*-1) + '%' });
        $items.eq(page).addClass('ui-active').siblings().removeClass('ui-active');

      }
        if ($pager.children().length>0) $pager.children('li').removeClass('ui-active').eq(page).addClass('ui-active');
        if(caption) caption.text($items.eq(page).data('caption'));
        if($thumb.length) $("li", $thumb).removeClass('ui-active').eq(page).addClass('ui-active');
        if(!carrusel){
          if(page == 0) $arrows.children(".ui-prev").hide();
          else $arrows.children(".ui-prev").show();

          if(page == pages -1) $arrows.children(".ui-next").hide();
          else $arrows.children(".ui-next").show();
        }
        $element.trigger('slide',{page:page});


      }


    function render(){
      var itemWidthIni, itemMargin, itemWidth, html = '', _pages, dif, size;
      if (sizesAuto){
        innerWidthIni = 0;
        $items.each(function(){
          //var cr = this.getClientRects && this.getClientRects();
          //innerWidthIni += (cr && cr[0] && cr[0].width) ? cr[0].width : $(this).outerWidth();
          innerWidthIni += $(this).outerWidth();
        });
        innerWidthIni = innerWidthIni+2 //bug
        $inner.width(innerWidthIni);
        _pages = Math.ceil(pages =(innerWidthIni/$inner.parent().width()));
      }else{
        size = sizes[currentSize];
        itemXPageIni = size[0];
        itemWidthIni = size[1];
        itemMarginIni = size[2];
        innerWidthIni = Math.round((itemWidthIni+itemMarginIni)*itemsLength);
        _pages = Math.ceil(pages =(innerWidthIni/100));
        $items.removeAttr('style'),
        $inner.removeAttr('style');

        $inner.css('width', (innerWidthIni+(itemMarginIni*pages)) +'%');
        if(heightAuto){
          setTimeout(function(){
            $inner.css({"height": $items.eq(0).outerHeight(true)});
          },500);
        }

        itemMargin = sn.utils.round (((itemMarginIni*100)/itemWidthIni) / itemsLength);
        itemWidth = (100/itemsLength)  - itemMargin;
        $items.css({
          'width': itemWidth + '%',
          'margin-right': (itemMarginIni?sn.utils.round(itemMargin):0)+'%'
        }).eq(0).addClass('ui-active');
        dif = 100-((itemMargin+ sn.utils.round(itemWidth))*itemsLength);
        /*if (dif!=0){

          if(navigator.userAgent.match(/iPhone|iPad|iPod/i)) $items.css({'width': itemWidth+ 0.0001 + '%' });
        }*/
      }



      //pager
      $pager.empty();
      page = (page>_pages)?_pages-1:page;
      if (_pages>1){
        for(var i=1; i <= _pages; i++){ html  += '<li>'+(i)+'</li>' };
        $pager.html(html).children('li').on('click',function(e){
          e.preventDefault();
          var _t = $(this);

          if (_t.hasClass('ui-active')) return;
          page = _t.prevAll().length;

          slide();
        }).eq(page).trigger('click');
        $pager.show()
      }else{
        $arrows.hide();
        $pager.hide()
      }
      if(page != 0 || !carrusel) slide();
      $element.addClass('orbit-ed');
    }
    function resize(){

      if (sizesAuto) return render();

      var winWidth = $(window,document).width(), widthOld = 0;
      for(var size in sizes){
        if (winWidth>=widthOld && winWidth<size){
          if (size != currentSize) {
            currentSize = size;
            render();
          }
          return;
        }
        widthOld = size;
      }
    }

    function cycle(){
      if (interval>0){
        timer = setInterval(function(){
          $('.ui-next',$arrows).trigger('click');
        },interval)
      }
    }

    if($thumb.length){
      $("li", $thumb).on('click',function(e){
        e.preventDefault();
        var $li = $(this);
        if (!$li.hasClass('ui-active')){
          page = $li.prevAll().length;
          slide();
        }
      });
    }

    $('.ui-prev, .ui-next',$arrows).on('click.gecui',function(e){
      e.preventDefault();
      var _pages = Math.ceil(pages);
      page +=($(this).hasClass('ui-prev')?(-1):(1));
      page = (page<0?(_pages-1):(page>=_pages?0:page));
      slide();
    });

    if (($element.data('resize')||'auto')=='auto'){ $(window).on('resize.gecui', resize)};

    $element.on('mouseenter',function(){
      clearInterval(timer);
    }).on('mouseleave',function(){
      cycle();
    });

    resize();
    cycle();
  }



  $(document).on('ready', function(){

    $('.ui-orbit').each( function(){
          new sn.orbit(this)
    });

  $("[name='session_value']").focus();
  });
