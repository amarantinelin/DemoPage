(function(global){

	var document = global.document;
	var active = /\s*active\s*/g;
	var activesidebarname;

	function isActive(el){
		if(!el)
		{
			return;
		}
		return active.test(el.className);
	}

	function deactivate(el){
		if(!el)
		{
			return;
		}
		el.className = el.className.replace(active,"");
	}

	function activate(el){
		if(!el)
		{
			return;
		}
		el.className += " active";
	}

	function addactiveclass(){
		var sidebarnames = document.getElementsByClassName("side__chartname");

		for( var i=0, len=sidebarnames.length; i<len; i++)
		{
			sidebarnames[i].addEventListener("click",function(e){

				if(isActive(this))
				{
					return;
				}

				deactivate(activesidebarname);
				activate(this);
				activesidebarname = this;


			});

		}

	}

	addactiveclass();

})(window);