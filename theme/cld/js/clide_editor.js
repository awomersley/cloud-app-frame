var clide_editor={
	
	ftp:0,
	token:0,
	id:0,
	
	init:function(lang,ftp,token,id){
		
		this.ftp=ftp;
		this.token=token;
		this.id=id;
		h=$('body').height()-30;
		$('#editor').css('height',h+'px');
		
		this.editor = ace.edit("editor");
        this.editor.setTheme("ace/theme/github");
        this.editor.session.setMode("ace/mode/"+lang);
		
		this.editor.on("change", function(e){ clide_editor.status(""); });
		
	},
	
	resizewindow:function(){
		
		h=$('#site').height()-30;
		$('#editor').css('height',h+'px');
		
		this.editor.resize();
		
	},
	
	status:function(s){
		
		$('#status').html(s);
		
		window.top.clide.unsaved(this.id,s);
		
	},
	
	save:function(file){
		
		contents=this.editor.getValue();
		
		$.post("/save", { file:file,contents:contents, ftp:this.ftp, token:this.token },
            function(data){
                
               clide_editor.status(data);
                        
         });
		
	},
	
	clse:function(){
		
		window.top.clide.clse(this.id);
		
	}
	
}