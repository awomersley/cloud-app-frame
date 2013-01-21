var clide={
	
	editor:0,
	type:0,
	tabs:Array(),
	opn:0,
	width:0,
	w:0,
	h:0,
	
	init:function(){
		
		$(window).resize(clide.resizewindow);
		
		this.resizewindow();
		
		
	
	},
	
	loadfiles:function(t){
		
		$('#dirscan .inner ul').load('/ajax/scan-dir', { site:$(t).attr('data-site'), file:'', pad:0 }, function() {
				 	
		});

	},
	
	resizewindow:function(){
		
		h=$('#site').height()-40;
		w=$('#site').width()-310;
		
		$('#edit, #edit iframe').css('height',h+'px');
		
		h=h-30;
		$('#content').css('height',h+'px');
		
		$('#col2').css('width',w+'px');
		
		
		clide.w=$('#site').width()-180;
		$('#holder').css('width',clide.w+'px');
		
		clide.maxscroll=clide.w;
		$('#nav li').each(function(){
			clide.maxscroll-=$(this).width()+15;
		});
		
		clide.resizeframes();
		
	},
	
	resizeframes:function(){
		
		$('#edit iframe').each(function(){
				document.getElementById($(this).attr('id')).contentWindow.clide_editor.resizewindow();
		});
		
	},
	
	clse:function(id){
		
		this.opn--;
		
		this.tabs[id]=false;
		
		$('#edit'+id).remove();
		$('#nav'+id).remove();
		$('#edit').css('display','none');
		
	},
	
	unsaved:function(id,status){
		
		if(status) $('#nav'+id+' .star').css('display','none');
		else $('#nav'+id+' .star').css('display','block');
	},
	
	
	edit:function(t){
		
		if(!this.tabs[$(t).attr('data-id')]){
			
			this.opn++;
			
			this.tabs[$(t).attr('data-id')]=true;
			
			/* show editor if left click - stay on file browser if mouse/right click */
			if(window.event.which==1){
				$('#edit').css('display','block');
				c='on';
			}else{
				c='';	
			}
			
			/* add li to #nav */
			$('#nav li').removeClass('on');
			$('#nav').append("<li id='nav"+$(t).attr('data-id')+"' data-id='"+$(t).attr('data-id')+"' data-path='"+$(t).attr('data-path')+"' class='"+c+"' onclick='clide.showeditor(this)'>"+$(t).attr('data-title')+"<div class='star'>*</div></li>");
			
			/* add div to #editor */
			$('#edit div').removeClass('on');
			$('#edit').append("<div id='edit"+$(t).attr('data-id')+"' data-id='"+$(t).attr('data-id')+"' class='"+c+"'><iframe id='iframe"+$(t).attr('data-id')+"' src='/edit?site="+$(t).attr('data-site')+"&path="+$(t).attr('data-path')+"' frameborder='0'></iframe></div>");
			//?ftp="+this.ftp+"&token="+this.token+"&file="+$(t).attr('data-path')+"&id="+$(t).attr('data-id')+"&height="+($('#site').height()-70)+"
			
			this.resizewindow();
			
		}else{
			$('#nav'+$(t).attr('data-id')).click();
		}
		
	},
	
	scrll:function(dir){
		
		if(this.maxscroll<0){
			
			left=parseInt($('#nav').attr('data-left'));
			
			if(dir==1){
				left-=100;
				if(left<this.maxscroll) left=this.maxscroll;
			}else{
				if(left<0){
					left+=100;
					if(left>0) left=0;
				}
			}
			
		}else{
			
			left=0;
		
		}
		
		$('#nav').attr('data-left',left);
		$('#nav').css('left',left+'px');
		
	},
	
	showeditor:function(t){
		
		id=$(t).attr('data-id');
		
		$('#nav li').removeClass('on');
		$('#nav'+id).addClass('on');
		
		$('#edit').css('display','block');
		$('#edit div').removeClass('on');
		$('#edit'+id).addClass('on');
		
		this.resizewindow();
		
	},
	
	showfiles:function(){
		
		$('#nav li').removeClass('on');
		$('#edit').css('display','none');
		
	},
	
	over:function(t){
		
		$(t).css('background','#F7F7F7');
		$(t).find('.mo').css('display','block');
		
	},
	
	out:function(t){
		
		$(t).css('background','none');
		$(t).find('.mo').css('display','none');
		
	},
	
	clk:function(t){
		
		if($(t).parent().parent().children('ul').css('display')=='block'){ 
		
			$(t).parent().parent().children('ul').css('display','none');
		
		}else{
			
			$(t).parent().parent().children('ul').css('display','block');
			
			if(!$(t).parent().parent().children('ul').html()){
				
				
				
				$(t).parent().parent().children('ul').load('/ajax/scan-dir', { site:$(t).parent().attr('data-site'), path: $(t).parent().attr('data-path'), pad: $(t).parent().attr('data-pad') }, function() {
				 	
				});
			
			}
		
		}

		return false;
		
	}
	
};