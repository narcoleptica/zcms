<!--

Ajax.init({ error: function (text) { alert('ERROR-ajax: ' + text); }, debug: true && 0 });

Timer.init({ w: 1000, span: false, term: [10000, 0], error: function (text) { alert('ERROR-timer: ' + text); }, debug: true && 0 });

function $(Id)
{
	var o = Id;
	if ((typeof o === 'string') || (o instanceof String)) o = document.getElementById(o);
	if ((typeof o === 'object') && o && (o instanceof Object)) return o;
	throw 'Unknow $(' + Id + ')';
}

$.innerHTMLstep = function (Id, text)
{
	try
	{
		var o = $(Id), I = String(text);
		if ('innerHTML' in o) o.innerHTML = ''; else throw 'now innerHTML found';
		var RE = '[\\<]script[^\\>]*?[\\>]([\\s\\S]*?)[\\<][\\/]script[\\>]', M = I.match(new RegExp(RE, 'igm'));
		if (!(M instanceof Array)) M = [];
		M.push(false);
		for (var i = 0, start = 0, js, index, s; i < M.length; i++)
		{
			js = (M[i] === false) ? false : String(M[i]);
			index = (js === false) ? -1 : I.indexOf(js, start);
			s = (index === -1) ? I.substr(start) : I.substring(start, index);
			if (s.trim().length > 0) { o.innerHTML += s; }
			start = index + js.length;
			if (js === false) continue;
			js = js.match(new RegExp(RE, 'im'))[1];
			try { eval(js); } catch (e) { alert('Error [' + e + "] in\n" + js); }
		}
	}
	catch (e) { alert('$.innerHTML' + e); }
	return false;
}

$.innerHTML = function (Id, text)
{
	try
	{
		var o = $(Id), I = String(text);
		if ('innerHTML' in o) o.innerHTML = ''; else throw 'now innerHTML found';
		var RE = '[\\<]script[^\\>]*?[\\>]([\\s\\S]*?)[\\<][\\/]script[\\>]', M = I.match(new RegExp(RE, 'igm'));
		if (!(M instanceof Array)) M = [];
		o.innerHTML = I;
		for (var i = 0, start = 0, js, index, s; i < M.length; i++)
		{
			js = String(M[i]);
			js = js.match(new RegExp(RE, 'im'))[1];
			try { eval(js); } catch (e) { alert('Error [' + e + "] in\n" + js); }
		}
	}
	catch (e) { alert('$.innerHTML' + e); }
	return false;
}

$.resize = function (Id, oldData, newData, speedData, stopData)
{
	if (!('css' in oldData) || !('width' in oldData) || !('height' in oldData)) throw '$.resize: oldData';
	else if (!('css' in newData) || !('width' in newData) || !('height' in newData) || !('opacity' in newData)) throw '$.resize: newData';
	var speed = { w: 0.01, h: 0.01, o: 0.01 };
	if((Number(speedData) > 0) && (Number(speedData) <= 1)) speed.w = speed.h = speed.o = Number(speedData);
	else if ((typeof data === 'object') && data && (data instanceof Object))
	{
		var w = false;
		if (('width' in speedData)) w = Number(speedData.width); else if (('w' in speedData)) w = Number(speedData.w);
		if (w && (w > 0) && (w <= 1)) speed.w = Math.max(w, Math.abs(speed.w));
		var h = false;
		if (('height' in speedData)) h = Number(speedData.height); else if (('h' in speedData)) h = Number(speedData.h);
		if (h && (h > 0) && (h <= 1)) speed.h = Math.max(h, Math.abs(speed.h));
		var p = false;
		if (('opacity' in speedData)) p = Number(speedData.opacity); else if (('o' in speedData)) p = Number(speedData.o);
		if (p && (p > 0) && (p <= 1)) speed.o = Math.max(p, Math.abs(speed.o));
	}
	var term = Math.max(Math.ceil(Math.min(speed.w, speed.h, speed.o) * 1000), 1);
	try
	{
		var sign = function (x) { return (x === 0) ? 0 : (x / Math.abs(x)); };
		var o = $(Id), L, LL, s, f, II = 0;
		l = { c: oldData.css, w: oldData.width, h: oldData.height, o: ('opacity' in oldData) ? oldData.opacity : o.style.opacity };
		//l.css = l.css.replace(/(^|;)(OVERFLOW|WIDTH|HEIGHT|OPACITY)[\:][^;]*(;|$)/igm, '$1');
		L = { c: newData.css, w: newData.width, h: newData.height, o: newData.opacity };
		//if (!(L.w > l.w) && !(L.h > l.h)) l.o = 1;
		var lw = Math.max(Math.abs(L.w - l.w), 0), lh = Math.max(Math.abs(L.h - l.h), 0), lo = Math.max(Math.abs(L.o - l.o), 0);
		var sw = sign(L.w - l.w), sh = sign(L.h - l.h), so = sign(L.o - l.o);
		s = { w: sw * Math.ceil(lw * speed.w), h: sh * Math.ceil(lh * speed.h), o: so * Math.max(lo * speed.o, 0.001) };
		//s.o = (s.o === false) ? Math.min((lw > 0) ? (Math.abs(s.w) / lw) : 1, (lh > 0) ? (Math.abs(s.h) / lh) : 1) : s.o;
		if (s.o < 0.01) s.o = 0.01;
		f = function (i)
		{
			var f = false, c;
			if (s.w > 0) { l.w = Math.min(l.w + s.w, L.w); if (l.w < L.w) { f = true; } }
			else if (s.w < 0) { l.w = Math.max(l.w + s.w, L.w); if (l.w > L.w) { f = true; } }
			if (s.h > 0) { l.h = Math.min(l.h + s.h, L.h); if (l.h < L.h) { f = true; } }
			else if (s.h < 0) { l.h = Math.max(l.h + s.h, L.h); if (l.h > L.h) { f = true; } }
			l.o = Math.min(l.o + s.o, L.o); if (l.o < L.o) { f = true; }
			var c = l.c + 'width: ' + l.w + 'px !important; height: ' + l.h + 'px !important; opacity: ' + l.o + '; overflow: hidden;';
			o.style.cssText = f ? c : L.c;
			return f;
		}
		return Timer.run({ wait: 0, term: [term], call: f, stop: stopData });
	}
	catch (e) { alert('$.resize' + e); }
	return false;
}

$.inner = function (Id, text, data)
{
	try
	{
		D = (typeof data === 'object') && data && (data instanceof Object) ? data : {};
		var o = $(Id);
		var newData = { css: String(o.style.cssText).replace(/(^|;[\s]*)(VISIBILITY)[\s]*[\:][^;]*(;|$)/igm, '$1').replace(/[\s]*[\;]+[\s]*$/, '') + ';' };
		if (newData.css === ';') newData.css = '';
		// old
		var oldData = { css: newData.css.replace(/[\s]+/gm, '') };
		o.style.cssText = oldData.css + 'visibility:hidden;';
		//oldData.css = oldData.css.replace(/(^|;)(WIDTH|HEIGHT|OPACITY|OVERFLOW)[\:][^;]*(;|$)/igm, '$1');
		oldData.width = o.clientWidth;
		oldData.height = o.clientHeight;
		oldData.opacity = 0;
		$.innerHTML(o, text);
		newData.width = o.clientWidth;
		newData.height = o.clientHeight;
		newData.opacity = 1;
		// nice
		$.resize(o, oldData, newData, D.speed, D.stop);
		
	}
	catch (e) { alert('$.inner' + e); }
	return false;
}

$.hidden = function (Id) { try { return String($(Id).style.display).match(/^none$/i); } catch (e) { alert('Error: $.hidden'); } return false; }

$.show = function (Id, data)
{
	try
	{
		var D = (typeof data === 'object') && data && (data instanceof Object) ? data : {};
		var o = $(Id), a = ('axes' in D) && (typeof D.axes === 'string') ? String(D.axes) : 'X Y';
		var newData = { css: String(o.style.cssText).replace(/(^|;[\s]*)(DISPLAY|VISIBILITY)[\s]*[\:][^;]*(;|$)/igm, '$1').replace(/[\s]*;+[\s]*$/, '') + ';' };
		if (newData.css === ';') newData.css = '';
		// old
		var oldData = { css: newData.css.replace(/[\s]+/gm, '') + 'display:block;' };
		//o.style.cssText = oldData.css + 'visibility:hidden;';
		//oldData.css = oldData.css.replace(/(^|;)(WIDTH|HEIGHT|OPACITY|OVERFLOW)[\:][^;]*(;|$)/igm, '$1');
		oldData.width = a.match(/(^|[\s]+)X([\s]+|$)/igm) ? 0 : o.clientWidth;
		oldData.height = a.match(/(^|[\s]+)Y([\s]+|$)/igm) ? 0 : o.clientHeight;
		oldData.opacity = 0;
		//
		newData.width = o.clientWidth;
		newData.height = o.clientHeight;
		newData.opacity = 1;
		$.resize(o, oldData, newData, D.speed, D.stop);
	}
	catch (e) { alert('Error: $.show'+e); }
	return false;
}

$.hide = function (Id, data)
{
	try
	{
		var D = (typeof data === 'object') && data && (data instanceof Object) ? data : {};
		var o = $(Id), a = ('axes' in D) && (typeof D.axes === 'string') ? String(D.axes) : 'X Y';
		var newData = { css: String(o.style.cssText).replace(/(^|;[\s]*)(DISPLAY|VISIBILITY)[\s]*[\:][^;]*(;|$)/igm, '$1').replace(/[\s]*;+[\s]*$/, '') + ';' };
		if (newData.css === ';') newData.css = '';
		// old
		var oldData = { css: newData.css.replace(/[\s]+/gm, '') };
		//o.style.cssText = oldData.css + 'visibility:hidden;';
		//oldData.css = oldData.css.replace(/(^|;)(WIDTH|HEIGHT|OPACITY|OVERFLOW)[\:][^;]*(;|$)/igm, '$1');
		oldData.width = o.clientWidth;
		oldData.height = o.clientHeight;
		oldData.opacity = 1;
		//
		newData.css += 'display:none;';
		newData.width = a.match(/(^|[\s]+)X([\s]+|$)/igm) ? 0 : oldData.width;
		newData.height = a.match(/(^|[\s]+)Y([\s]+|$)/igm) ? 0 : oldData.height;
		newData.opacity = 0;
		$.resize(o, oldData, newData, D.speed, D.stop);
	}
	catch (e) { alert('Error: $.hide' +e); }
	return false;
}

function counter (area, counter, length)
{
	var T = $(area), t = String(T.value), C = $(counter), L = (Number(length) > 0) ? Number(length) : 1;
	try { if (t.length > L) T.value = t = t.substr(0, L); C.value = L - t.length; } catch (e) { }
}

function loadZ(Id, content, stop)
{
	var tt = false; //{ stop: function() { $.hide(Id, { stop: function () { $.show(Id, { axes: 'Y' }); }, speed: 0.0001, axes: 'Y' }) }, speed: { w: 0.01, h: 0.001 } };
	var t = function (t) { $.inner(Id, t, tt); };
	var ee = { stop: true, speed: { w: 0.01, h: 0.001, o: 0.001 } };
	var e = function (t) { $.inner(Id, 'ajax-error: request fait', ee); };
	var inner = { stop: function () { Ajax.post({ c:content, t:t, e:e }); }, speed: { w: 0.01, h: 0.001, o: 0.01 } };
	$.inner(Id, '<div class="loading"></div>', inner );
	return false; 
}

function loadContent(content) { return loadZ('document-content-wrapper', content); }

function goToPage (module, page) { return loadContent([['ajax', module], ['do', page]]); }

//-->