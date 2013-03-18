<!--

var Hover = {
	init_object: function (O)
	{
		try
		{ 
			var t = O, P = [/(^|\s)hover(\s|$)/gm, /(^|\s)HOVER(?:[\s]+highlight)?(\s|$)/gm], R = ['$1HOVER$2', '$1HOVER highlight$2'];
			if (!String(O.className).match(P[0])) return;
			O.className = O.className.replace(P[0], R[0]);
			O.onmouseover = function() { try { this.className = this.className.replace(P[1], R[1]); } catch(e) { } };
			O.onmouseout = function() { try { this.className = this.className.replace(P[1], R[0]); } catch(e) { } };
		}
		catch (e) { }
	}
	init_tag: function (tag) { for (var T = document.getElementsByTagName(String(tag)), i = 0; i < T.length; i++) Hover.init_object(T[i]); }
	init: function () { for (var T = ['div', 'tr'], i = 0; i < T.length; i++) Hover.init_tag(T[i]); }
}
Hover.init();

//-->