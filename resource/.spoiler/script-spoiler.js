<!--

var Spoiler = {
	is: function (object)
	{
		var P = [/(^|\s)SPOILER(\s|$)/gm, /(^|\s)SPOILER[\s]+expanded(\s|$)/gm];
		try
		{
			if ((typeof object === 'string') || (object instanceof String)) object = document.getElementById(object);
			if (String(object.className).match(P[1])) return true;
			else if(String(object.className).match(P[0])) return false;
		}
		catch(e) { }
		return null;
	},
	run: function (object, state)
	{
		var P = [/(^|\s)SPOILER(\s|$)/gm, /(^|\s)SPOILER[\s]+expanded(\s|$)/gm], R = ['$1SPOILER$2', '$1SPOILER expanded$2'];
		try
		{
			if ((typeof object === 'string') || (object instanceof String)) object = document.getElementById(object);
			if (typeof state === 'boolean') object.className = object.className.replace(P[1], state ? R[1] : R[0]);
			else if(object.className.match(P[1])) { object.className = object.className.replace(P[1], R[0]); state = true; }
			else if (object.className.match(P[0])) { object.className = object.className.replace(P[0], R[1]); state = false; }
			else throw 'return';
			return state;
		}
		catch(e) { }
		return null;
	},
	init: function ()
	{
		var P = /(^|\s)spoiler(\s|$)/gm, R = '$1SPOILER$2', SPOILER;
		SPOILER = function (t)
		{
			if (!String(t.className).match(P)) return;
			t.className = t.className.replace(P, R);
			var D = document, a = D.createElement('a'), d1 = D.createElement('div'), d2 = D.createElement('div');
			// spoiler > a.spoiler-link[rel=spoiler]
			a.className = 'spoiler-link';
			a.rel = 'spoiler';
			a.href = '#';
			var tClick = t.onclick, tDblClick = t.ondblclick;
			t.onclick = t.ondblclick = null;
			a.onclick = function (event) { try { tClick(event); } catch (e) { } Spoiler.run(this.parentNode); return false; };
			a.ondblclick = function (event) { try { tDblClick(event); } catch (e) { } return false; };
			// spoiler > a > div.spoiler-title[rel=spoiler]
			d1.className = 'spoiler-title';
			d1.rel = 'spoiler';
			d1.title='Чтобы развернуть, нажмите один раз, для сворачивания нажмите еще раз';
			d1.innerHTML = (t.title.length > 0) ? t.title : 'Скрытый текст';
			t.title = '';
			// spoiler > div.spoiler-content[rel=spoiler]
			d2.className = 'spoiler-content';
			d2.rel = 'spoiler';
			d2.innerHTML = t.innerHTML;
			t.innerHTML = '';
			// spoiler
			t.appendChild(a);
			a.appendChild(d1);
			t.appendChild(d2);
		}
		var T = document.getElementsByTagName('div');
		for (var i = 0; i < T.length; i++) { try { SPOILER(T[i]); } catch (e) { } }
	}
}
Spoiler.init();

//-->