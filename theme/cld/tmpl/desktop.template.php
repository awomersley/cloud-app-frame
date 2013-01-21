<!doctype html>  
<html lang='en'>
<head>{{hook.pre-head}}{{cld.head}}{{hook.post-head}}</head>
<body class='<?=$VAR_templatemode;?>'>
{{hook.page-top}}
<div id='site'>	
	
    {{hook.header}}
    
    <div id='content'>
			<div id='col1'>{{hook.col1}}</div>
            <div id='col2'>{{hook.col2}}</div>
            <div id='col3'>{{hook.col3}}</div>
    </div>
    
    {{hook.footer}}
    
</div>
{{hook.page-bottom}}
{{cld.debug}}
</body>
</html>