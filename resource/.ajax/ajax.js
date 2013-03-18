<!--

/** /
	var ajax = {
		// ( object:{ pre: 'http:', host: 'zanner.org.ua', path: '/z/z/z/', data: [], post: string } | null = defaultData.uri )
		( uri | u )  :  ( string | object:{ pre: string, host: string, path: string, data: string, post: string } | null = defaultData.uri )
		uriText : string
		( method | m )  :  ( 'GET' | 'POST' | 'PUT' | null = defaultData.method:'GET' )
		( async | a )  :  ( bool | null = defaultData.async:true )
		( login | l )  :  ( string | bool | null = defaultData.login:false )
		( password | p )  :  ( string | bool | null = defaultData.password:false )
		( head | h )  :  ( array | null = defaultData.head:[] )
		( content | c )  :  ( array | null = defaultData.content:[] )
		( timeout | to )  :  ( int | null = defaultData.timeout:0 )
		( wait | w )  :  ( int | null = defaultData.wait:0 )
		// function
		debug  :  ( funciton | null = defaultData.debug )
		call  :  ( funciton | null = defaultData.call )
		( sending | s1 )  :  ( funciton | null = defaultData.sending )
		( sended | s2 )  :  ( funciton | null = defaultData.sended )
		( receiving | r1 )  :  ( funciton | null = defaultData.receiving )
		( received | r2 )  :  ( funciton | null = defaultData.received )
		( error | e )  :  ( funciton | null = defaultData.error )
		( success | s )  :  ( funciton | null = defaultData.success )
		( text | t )  :  ( funciton | null = defaultData.text )
		( xml | x )  :  ( funciton | null = defaultData.xml )
	};
	var Ajax = new ajaxThread(ajax);
	Ajax.run(ajax);
	Ajax.get(ajax);
	Ajax.post(ajax);
	Ajax.form(ajax);
	Ajax.formSubmit(ajax);
/**/

function ajaxThread(id, initing, run)
{
	var isString, isNumber, isBoolean, isScalar, isArray, isObject, isFunction;
	isString = function (data) { return (typeof data === 'string') || (data instanceof String); };
	isNumber = function (data) { return (typeof data === 'number') || (data instanceof Number); };
	isBoolean = function (data) { return (typeof data === 'boolean') || (data instanceof Boolean); };
	isScalar = function (data) { return isString(data) || isNumber(data) || isBoolean(data); };
	isArray = function (data) { return (data instanceof Array); };
	isObject = function (data) { return (typeof data === 'object') && data && (data instanceof Object); };
	isFunction = function (data) { return (typeof data === 'function') || (data instanceof Function); };
	//
	var cloneObject, cloneArray, arrayKVarray, objectKVarray, dataKVarrays;
	cloneObject = function (objectOld, f, destroy)
	{
		f = (f === undefined) ? 0xFF : f;
		var objectNew = {};
		if (isObject(objectOld))
		{
			for (o in objectOld)
			{
				if ((f & 0x01) && isString(objectOld[o])) { objectNew[o] = objectOld[o]; }
				else if ((f & 0x02) && isNumber(objectOld[o])) { objectNew[o] = objectOld[o]; }
				else if ((f & 0x04) && isBoolean(objectOld[o])) { objectNew[o] = objectOld[o]; }
				else if ((f & 0x07) && isScalar(objectOld[o])) { objectNew[o] = objectOld[o]; }
				else if ((f & 0x08) && isArray(objectOld[o])) { objectNew[o] = cloneArray(objectOld[o]); }
				else if ((f & 0x10) && isObject(objectOld[o])) { objectNew[o] = cloneObject(objectOld[o], f, destroy); }
				else if ((f & 0x20) && isFunction(objectOld[o])) { objectNew[o] = objectOld[o]; }
				else { objectNew[o] = objectOld[o]; }
			}
			if (destroy === true) delete objectOld;
		}
		return objectNew;
	}
	cloneArray = function (arrayOld)
	{
		var arrayNew = [];
		if (isArray(arrayOld)) { for (var i = 0; i < arrayOld.length; i++) { arrayNew[i] = arrayOld[i]; } }
		else arrayNew = [arrayOld];
		return arrayNew;
	}
	arrayKVarray = function (arrayOld, arrayNew, f, f1, f2)
	{
		if (!isArray(arrayOld)) { }
		else if ((f & f1) && (arrayOld.length === 1) && isString(arrayOld[0]))
		{
			arrayNew[arrayNew.length] = arrayOld;
			return true;
		}
		else if ((f & f2) && (arrayOld.length === 2) && isScalar(arrayOld[0]) && isScalar(arrayOld[1]))
		{
			arrayNew[arrayNew.length] = [arrayOld[0], arrayOld[1]];
			return true;
		}
		return false;
	}
	objectKVarray = function (objectOld, arrayNew, f, f8)
	{
		if ((f & f8) && isObject(objectOld))
		{
			var key = null, value = null;
			if (('key' in objectOld) && isScalar(objectOld.key)) key = objectOld.key;
			else if (('k' in objectOld) && isScalar(objectOld.k)) key = objectOld.k;
			else if (('label' in objectOld) && isScalar(objectOld.label)) key = objectOld.label;
			else if (('l' in objectOld) && isScalar(objectOld.l)) key = objectOld.l;
			if (('value' in objectOld) && isScalar(objectOld.value)) value = objectOld.value;
			else if (('v' in objectOld) && isScalar(objectOld.v)) value = objectOld.v;
			if ((key !== null) && (value !== null))
			{
				arrayNew[arrayNew.length] = [key, value];
				return true;
			}
		}
		return false;
	}
	dataKVarrays = function (dataOld, arrayOld, f)
	{
		f = (f === undefined) ? 0xFF : f;
		var arrayNew = isArray(arrayOld) ? cloneArray(arrayOld) : [], a, o;
		if (arrayKVarray(dataOld, arrayNew, f, 0x01, 0x02)) { }
		else if (objectKVarray(dataOld, arrayNew, f, 0x08)) { }
		else if ((f & 0x04) && isArray(dataOld) && (dataOld.length > 0))
		{
			for (var i = 0; i < dataOld.length; i++)
			{
				if (arrayKVarray(dataOld[i], arrayNew, f, 0x01, 0x02)) { }
				else if (objectKVarray(dataOld[i], arrayNew, f, 0x08)) { }
			}
		}
		return arrayNew;
	}
	//
	var TO, dataKVdata;
	TO =
	{
		uri: function (uri, defaultReturn)
		{
			var uriNew = cloneObject(defaultReturn), RE;
			if (isString(uri))
			{
				RE = /^([^\:]+[\:])((?:[\/]{1,2}|[\?]|[\#]).*)?$/;
				if (uri.match(RE)) { uriNew.pre = uri.replace(RE, '$1'); uri = uri.replace(RE, '$2'); }
				RE = /^[\/]{2}([^\/\?\#]+)((?:[\/]|[\?]|[\#]).*)?$/;
				if (uri.match(RE)) { uriNew.host = uri.replace(RE, '$1'); uri = uri.replace(RE, '$2'); }
				RE = /^([\/][^\?\#]*)((?:[\?]|[\#]).*)?$/;
				if (uri.match(RE)) { uriNew.path = uri.replace(RE, '$1'); uri = uri.replace(RE, '$2'); }
				RE = /^([\?][^\#]*)([\#].*)?$/;
				if (uri.match(RE)) { uriNew.data = uri.replace(RE, '$1'); uri = uri.replace(RE, '$2'); }
				RE = /^([\#].*)$/;
				if (uri.match(RE)) { uriNew.post = uri.replace(RE, '$1'); }
			}
			else if (isObject(uri))
			{
				RE = [ /^[^\:\/]+(:?[\:][\/]{0,2})?$/, /[\:][\/]{0,2}$/ ];
				if (('pre'  in uri) && String(uri.pre ).match(RE[0])) uriNew.pre  = String(uri.pre).replace(RE[1], '') + ':';
				RE = [ /^[\/]{0,2}[^\/\?\#]+$/, /^[\/]{1,2}/ ];
				if (('host' in uri) && String(uri.host).match(RE[0])) uriNew.host = String(uri.host).replace(RE[1], '');
				RE = [ /^[\/]{0,1}[^\?\#]*$/, /^[\/]{0,1}/ ];
				if (('path' in uri) && String(uri.path).match(RE[0])) uriNew.path = '/' + String(uri.path).replace(RE[1], '');
				RE = [ /^[\?]{0,1}[^\?\#]*$/, /^[\?]{0,1}/ ];
				if (('data' in uri) && String(uri.data).match(RE[0])) uriNew.data = '?' + String(uri.data).replace(RE[1], '');
				RE = [ /^[\#]{0,1}[^\#]*$/, /^[\#]{0,1}/ ];
				if (('post' in uri) && String(uri.post).match(RE[0])) uriNew.post = '#' + String(uri.post).replace(RE[1], '');
			}
			return uriNew;
		},
		uriText: function (uri) { return String(uri.pre + '//' + uri.host + uri.path + uri.data + uri.post); },
		method: function (method, defaultReturn) { return String(method).match(/^(GET|POST|PUT)$/igm) ? String(method).toUpperCase() : defaultReturn; },
		async: function (async, defaultReturn) { return ((async === true) || (async === false)) ? async : defaultReturn; },
		login: function (login, defaultReturn) { return isString(login) ? String(login) : defaultReturn; },
		password: function (password, defaultReturn) { return isString(password) ? String(password) : defaultReturn; },
		head: function (head, defaultReturn) { return dataKVarrays(head, defaultReturn, 0x02 | 0x04 | 0x08); },
		content: function (content, defaultReturn)
		{
			var A = dataKVarrays(content, defaultReturn, 0x01 | 0x02 | 0x04 | 0x08);
			for (var i = 0; i < A.length; i++)
			{
				if (A[i].length === 1)
				{
					var key = String(A[i]).replace(/^([^\=]*)\=.*$/m, '$1');
					var val = String(A[i]).replace(/^[^\=]*\=(.*)$/m, '$1');
					A[i] = [key, val];
				}
			}
			return A;
		},
		timeout: function (timeout, defaultReturn) { return String(timeout).match(/^[\d]+$/) ? timeout : defaultReturn; },
		wait: function (wait, defaultReturn) { return String(wait).match(/^[\d]+$/) ? wait : defaultReturn; },
		func: function (func, defaultReturn) { return isFunction(func) ? func : defaultReturn; }
	};
	dataKVdata = function (data, variable, constant)
	{
		data = isObject(data) ? data : {};
		delete variable.uri;
		if ('uri' in data) variable.uri = TO.uri(data.uri, constant.uri);
		else if ('u' in data) variable.uri = TO.uri(data.u, constant.uri);
		else variable.uri = TO.uri(null, constant.uri);
		variable.uriText = TO.uriText(variable.uri);
		if ('method' in data) variable.method = TO.method(data.method, constant.method);
		else if ('m' in data) variable.method = TO.method(data.m, constant.method);
		else variable.method = TO.method(null, constant.method);
		if ('async' in data) variable.async = TO.async(data.async, constant.async);
		else if ('a' in data) variable.async = TO.async(data.a, constant.async);
		else variable.async = TO.async(null, constant.async);
		if ('login' in data) variable.login = TO.login(data.login, constant.login);
		else if ('l' in data) variable.login = TO.login(data.l, constant.login);
		else variable.login = TO.login(null, constant.login);
		if ('password' in data) variable.password = TO.password(data.password, constant.password);
		else if ('p' in data) variable.password = TO.password(data.p, constant.password);
		else variable.password = TO.password(null, constant.password);
		delete variable.head;
		if ('head' in data) variable.head = cloneArray(constant.head).concat(TO.head(data.head, []));
		else if ('h' in data) variable.head = cloneArray(constant.head).concat(TO.head(data.h, []));
		else variable.head = cloneArray(constant.head);
		delete variable.content;
		if ('content' in data) variable.content = cloneArray(constant.content).concat(TO.content(data.content, []));
		else if ('c' in data) variable.content = cloneArray(constant.content).concat(TO.content(data.c, []));
		else variable.content = cloneArray(constant.content);
		if ('timeout' in data) variable.timeout = TO.timeout(data.timeout, constant.timeout);
		else if ('to' in data) variable.timeout = TO.timeout(data.to, constant.timeout);
		else variable.timeout = TO.timeout(null, constant.timeout);
		if ('wait' in data) variable.wait = TO.wait(data.wait, constant.wait);
		else if ('w' in data) variable.wait = TO.wait(data.w, constant.wait);
		else variable.wait = TO.wait(null, constant.wait);
		// function
		if ('debug' in data) variable.onDebug = (data.debug === true) ? data.debug : TO.func(data.debug, constant.onDebug);
		else variable.onDebug = TO.func(null, constant.onDebug);
		if ('call' in data) variable.onCall = TO.func(data.call, constant.onCall);
		else variable.onCall = TO.func(null, constant.onCall);
		if ('sending' in data) variable.onSending = TO.func(data.sending, constant.onSending);
		else if ('s1' in data) variable.onSending = TO.func(data.s1, constant.onSending);
		else variable.onSending = TO.func(null, constant.onSending);
		if ('sended' in data) variable.onSended = TO.func(data.sended, constant.onSended);
		else if ('s2' in data) variable.onSended = TO.func(data.s2, constant.onSended);
		else variable.onSended = TO.func(null, constant.onSended);
		if ('receiving' in data) variable.onReceiving = TO.func(data.receiving, constant.onReceiving);
		else if ('r1' in data) variable.onReceiving = TO.func(data.r1, constant.onReceiving);
		else variable.onReceiving = TO.func(null, constant.onReceiving);
		if ('received' in data) variable.onReceived = TO.func(data.received, constant.onReceived);
		else if ('r2' in data) variable.onReceived = TO.func(data.r2, constant.onReceived);
		else variable.onReceived = TO.func(null, constant.onReceived);
		if ('error' in data) variable.onError = TO.func(data.error, constant.onError);
		else if ('e' in data) variable.onError = TO.func(data.e, constant.onError);
		else variable.onError = TO.func(null, constant.onError);
		if ('success' in data) variable.onSuccess = TO.func(data.success, constant.onSuccess);
		else if ('s' in data) variable.onSuccess = TO.func(data.s, constant.onSuccess);
		else variable.onSuccess = TO.func(null, constant.onSuccess);
		if ('text' in data) variable.onSuccessText = TO.func(data.text, constant.onSuccessText);
		else if ('t' in data) variable.onSuccessText = TO.func(data.t, constant.onSuccessText);
		else variable.onSuccessText = TO.func(null, constant.onSuccessText);
		if ('xml' in data) variable.onSuccessXml = TO.func(data.xml, constant.onSuccessXml);
		else if ('x' in data) variable.onSuccessXml = TO.func(data.x, constant.onSuccessXml);
		else variable.onSuccessXml = TO.func(null, constant.onSuccessXml);
	}
	//
	var ajaxId, ajaxObject, ajaxState, defaultData, constantData, variableData, URI = location;
	try { ajaxObject = new XMLHttpRequest(); }
	catch (e)
	{
		var ajaxObjectText=
		[
			'MSXML2.XMLHTTP.6.0',
			'MSXML2.XMLHTTP.5.0',
			'MSXML2.XMLHTTP.4.0',
			'MSXML2.XMLHTTP.3.0',
			'MSXML2.XMLHTTP',
			'Microsoft.XMLHTTP'
		];
		for (var i = 0; i < ajaxObjectText.length; i++)
			try { ajaxObject = new ActiveXObject(ajaxObjectText[i]); break; } catch (e){ }
	}
	ajaxState = false;
	defaultData =
	{
		uri: { pre: URI.protocol, host: URI.host, path: URI.pathname, data: URI.search, post: URI.hash }, // адресс отправки
		uriText: '',
		method: 'GET', // метод отправки {'GET' | 'POST' | 'PUT'}
		async: true, // режим отправки {true=асинхронный | false=синхронный}
		login: false, // пользователь для авторизации
		password: false, // пароль для авторизации
		head: [ ['Pragma', 'no-cache'], ['Cache-Control', 'no-cache'] ], // мето данные (заголовки)
		content: [], // параметры
		timeout: 0, // максимальная время ожидания ответа
		wait: 0, // задержка перед отправкой
		onDebug: false, // функция отладки
		onCall: function () { }, // функция обращения к одной из ниже перечисленых
		onSending: function () { }, // функция: сообщение отправляется
		onSended: function () { }, // функция: сообщение отправлено
		onReciving: function () { }, // функция: получение ответа
		onRecived: function () { }, // функция: ответ получен
		onError: function () { }, // функция: возврат ошибки при отправки
		onSuccess: function () { }, // функция: отправка прошла удачно
		onSuccessText: function () { }, // функция: отправка прошла удачно - вернуть в виде текста
		onSuccessXml: function () { } // функция: отправка прошла удачно - вернуть в виде xml
	};
	defaultData.uriText = TO.uriText(defaultData.uri);
	constantData = cloneObject(defaultData, 0xFF, true);
	variableData = cloneObject(constantData, 0xFF, true);
	//
	var DEBUG = function (text) { var o = variableData; if (isFunction(o.onDebug)) o.onDebug(text); else if (o.onDebug) alert(text); }
	var STATE, STATUS, RESPONSE, HEADERING, HEADER, HEADERS;
	// состояние запроса = state {0 = not opened, 1 = opened || sending, 2 = sended, 3 = receiving, 4 = received}
	STATE = function () { try { return ajaxObject.readyState; } catch (e) { DEBUG('Error: ajax[' + ajaxId + '].state.'); } return null; }
	STATUS = function (status) // состояния запроса = status (код, сообщение)
	{
		var code = null, message = null;
		if (ajaxState === 4) { try { code = ajaxObject.status; } catch (e) { DEBUG('Error: ajax[' + ajaxId + '].status.code.'); } }
		if (ajaxState === 4) { try { message = ajaxObject.statusText; } catch (e) { DEBUG('Error: ajax[' + ajaxId + '].status.text.'); } }
		if (status === 1) return code;
		else if (status === 2) return message;
		else if (status === 3) return {msg: message, txt: message};
		else if (status === 4) return {c: code, m: message, t: message};
		else if (status === 5) return {code: code, message: message, text: message};
		else if (status === 6) return {c: code, m: message, t: message, code: code, message: message, text: message, msg: message, txt: message};
		return code;
	}
	RESPONSE = function (response) // ответ на запрос = response (текст, XML)
	{
		var text = null, xml = null;
		if (ajaxState === 4) { try { text = ajaxObject.responseText; } catch (e) { DEBUG('Error: ajax[' + ajaxId + '].response.text.'); } }
		if (ajaxState === 4) { try { xml = ajaxObject.responseXML; } catch (e) { DEBUG('Error: ajax[' + ajaxId + '].response.xml.'); } }
		if (response === 1) return text;
		else if (response === 2) return xml;
		else if (response === 3) return {t: text, x: xml};
		else if (response === 4) return {text: text, xml: xml};
		else if (response === 5) return {t: text, x: xml, text: text, xml: xml};
		return text;
	}
	HEADERING = function (key, value)
	{
		try { ajaxObject.setRequestHeader(String(key), String(value)); return true; } catch (e) { DEBUG('Error: ajax[' + ajaxId + '].header.set.'); }
		return false;
	}
	HEADER = function (key) { try { return ajaxObject.getResponseHeader(key); } catch (e) { DEBUG('Error: ajax[' + ajaxId + '].header.get.'); } return false; }
	HEADERS = function () { try { return ajaxObject.getAllResponseHeaders(); } catch (e) { DEBUG('Error: ajax[' + ajaxId + '].header.getAll.'); } return false; }
	//
	var CALL, SENDING, SENDED, RECIVING, RECIVED, ERROR, SUCCESS;
	CALL = function () { try { var o = variableData; if (isFunction(o.onCall)) o.onCall(ajaxState, STATUS(6)); } catch(e) { DEBUG('Error: ajax[' + ajaxId + '].call.'); } }
	SENDING = function () { ajaxState = 1; CALL(); try { var o = variableData; if (isFunction(o.onSending)) o.onSending(ajaxState, STATUS(6)); } catch(e) { DEBUG('Error: ajax[' + ajaxId + '].sending.'); } }
	SENDED = function () { ajaxState = 2; CALL(); try { var o = variableData; if (isFunction(o.onSended)) o.onSended(ajaxState, STATUS(6)); } catch(e) { DEBUG('Error: ajax[' + ajaxId + '].sended.'); } }
	RECIVING = function () { ajaxState = 3; CALL(); try { var o = variableData; if (isFunction(o.onReciving)) o.onReciving(ajaxState, STATUS(6)); } catch(e) { DEBUG('Error: ajax[' + ajaxId + '].reciving.'); } }
	RECIVED = function () { ajaxState = 4; CALL(); try { var o = variableData; if (isFunction(o.onRecived)) o.onRecived(ajaxState, STATUS(6)); } catch(e) { DEBUG('Error: ajax[' + ajaxId + '].recived.'); } }
	ERROR = function () { try { var o = variableData; if (isFunction(o.onError)) o.onError(ajaxState, STATUS(6)); } catch(e) { DEBUG('Error: ajax[' + ajaxId + '].error.'); } }
	SUCCESS = function ()
	{
		var o = variableData, text = RESPONSE(1), xml = RESPONSE(2);
		try { if (isFunction(o.onSuccess)) o.onSuccess(text, xml, STATUS(6), ajaxState); } catch(e) { DEBUG('Error: ajax[' + ajaxId + '].success.'); }
		try { if (isFunction(o.onSuccessText)) o.onSuccessText(text, STATUS(6), ajaxState); } catch(e) { DEBUG('Error: ajax[' + ajaxId + '].success.text.'); }
		try { if (isFunction(o.onSuccessXml)) o.onSuccessXml(xml, STATUS(6), ajaxState); } catch(e) { DEBUG('Error: ajax[' + ajaxId + '].success.xml.'); }
	}
	//
	var freeUse = false, FREE, CLOSE, OPEN, SEND, CHANGE;
	FREE = function (use)
	{
		if (freeUse === true) return false;
		else if (use === true) freeUse = true;
		return ((ajaxState === false) || (ajaxState === 4)) ? true : false;
	}
	// остановка исполнение текущего запроса = abort
	CLOSE = function ()
	{
		var state = ajaxState;
		try
		{
			ajaxObject.onreadystatechange = null;
			ajaxObject.abort();
			ajaxState = false;
			freeUse = false;
			return true;
		}
		catch (e)
		{
			ajaxState = state;
			DEBUG('Error: ajax[' + ajaxId + '].close.');
		}
		return false;
	}
	// иницализация параметров запроса = open
	OPEN = function ()
	{
		freeUse = true;
		if (ajaxState === false)
		{
			var state = ajaxState;
			try
			{
				ajaxState = 0;
				var o = variableData;
				if (o.content.length > 0)
				{
					var content = [];
					for (var i = 0; i < o.content.length; i++) content[i] = encodeURIComponent(o.content[i][0]) + '=' + encodeURIComponent(o.content[i][1]);
					content = String(content.join('&'));
					//
					if (o.method.match(/^GET$/i))
					{
						o.head = o.head.concat(TO.head([['Content-length', o.content.length]], []));
						o.head = o.head.concat(TO.head([['Connection', 'close']], []));
						o.content = null;
						o.uri.data = String(o.uri.data).match(/^\?.*$/) ? (o.uri.data + '&' + content) : ('?' + content);
					}
					else if (o.method.match(/^POST$/i))
					{
						try
						{
							for (var i = 0; i < o.head.length; i++) { if (String(o.head[i][0]).match(/^Content-Type$/i)) { throw 'Content-Type exists'; } }
							o.head = TO.head([['Content-Type', 'application/x-www-form-urlencoded']], []).concat(o.head);
						}
						catch (e) { }
						o.content = content;
					}
					else o.content = null;
				}
				else o.content = null;
				o.uriText = TO.uriText(o.uri);
				var D = [];
				D[D.length] = 'method=[' + o.method + ']';
				D[D.length] = 'uri=[' + o.uriText + ']';
				D[D.length] = o.async ? 'async' : 'sync';
				if (o.login && o.password) D[D.length] = o.login + '@' + o.password;
				DEBUG('Debug: ajax[' + ajaxId + '].open.' + "\n" + D.join(' '));
				if (!isString(o.login)) ajaxObject.open(o.method, o.uriText, o.async);
				else if (!isString(o.password)) ajaxObject.open(o.method, o.uriText, o.async, o.login);
				else ajaxObject.open(o.method, o.uriText, o.async, o.login, o.password);
				//var header = [];
				//for (var H = o.head, i = 0; i < H.length; i++) { HEADERING(H[i][0], H[i][1]); header[header.length] = H[i][0] + ':' + H[i][1]; }
				//D[D.length] = 'header=[' + header.join(', ') + ']';
				//DEBUG('Debug: ajax[' + ajaxId + '].opened.' + "\n" + D.join(' '));
				return true;
			}
			catch (e)
			{
				ajaxState = state;
				DEBUG('Error: ajax[' + ajaxId + '].open.');
			}
		}
		return false;
	}
	// выполнение запроса = send
	SEND = function ()
	{
		freeUse = true;
		if (ajaxState === 0)
		{
			try
			{
				var o = variableData;
				if (o.wait > 0)
				{
					var D = ['wait=[' + o.wait + ']'];
					DEBUG('Debug: ajax[' + ajaxId + '].send.' + "\n" + D.join(' '));
					window.setTimeout(SEND, o.wait);
					o.wait = 0;
				}
				else
				{
					var D = [];
					var header = [];
					for (var H = o.head, i = 0; i < H.length; i++) { HEADERING(H[i][0], H[i][1]); header[header.length] = H[i][0] + ':' + H[i][1]; }
					D[D.length] = 'header=[' + header.join(', ') + ']';
					if (o.content) D[D.length] = 'content=[' + o.content + ']';
					DEBUG('Debug: ajax[' + ajaxId + '].send.' + "\n" + D.join(' '));
					o.timeout = (o.timeout > 0) ? window.setTimeout(CLOSE, o.timeout) : false;
					ajaxObject.onreadystatechange = CHANGE;
					ajaxObject.send(o.content);
					return true;
				}
			}
			catch(e) { DEBUG('Error: ajax[' + ajaxId + '].send.'); }
		}
		//else if (ajaxState === false) return OPEN() ? SEND() : false;
		//else if (ajaxState === 4) { return (CLOSE() && OPEN()) ? SEND() : false; }
		return false;
	}
	//
	CHANGE = function ()
	{
		//freeUse = true;
		var state = STATE();
		if (state === 4)
		{
			if (isFunction(variableData.timeout)) window.clearTimeout(variableData.timeout);
			RECIVED();
			var status = STATUS(1), response = String(RESPONSE(1)).replace(/^\s+/gm, '').replace(/\s+$/gm, '');
			var D = ['state=[' + state + ']', 'status=[' + status + ']'];
			if (status === 200) D[D.length] = 'response=[' + response + ']';
			DEBUG('Debug: ajax[' + ajaxId + '].change.' + "\n" + D.join(' '));
			(status === 200) ? SUCCESS() : ERROR();
			ajaxObject.onreadystatechange = null;
			freeUse = false;
		}
		else
		{
			var D = ['state=[' + state + ']'];
			DEBUG('Debug: ajax[' + ajaxId + '].change.' + "\n" + D.join(' '));
			if (state === 1) SENDING();
			else if (state === 2) SENDED();
			else if (state === 3) RECIVING();
		}
	}
	var INITIALIZATION, RUN, GET, POST, FORM_ELEMENTS, FORM_SUBMIT;
	INITIALIZATION = function (data) { dataKVdata(data, constantData, defaultData); dataKVdata(data, variableData, constantData); }
	RUN = function (data)
	{
		dataKVdata(data, variableData, constantData);
		if ((ajaxState !== false) && !CLOSE()) return false;
		else if (!OPEN()) return false;
		else if (!SEND()) return false;
		return true;
	}
	GET = function (data)
	{
		if (!isObject(data)) data = { };
		data.method = 'GET';
		return RUN(data);
	}
	POST = function (data)
	{
		if (!isObject(data)) data = { };
		data.method = 'POST';
		return RUN(data);
	}
	FORM_ELEMENTS = function (F, active)
	{
		var result = [];
		try
		{
			F = (typeof F === 'string') ? document.getElementById(F) : F;
			active = (active === false) ? false : true;
			if (!('tagName' in F)) throw 'wrong Form';
			else if (!String(F.tagName).match(/^(button|form|input|option|select|textarea)$/ig)) throw 'wrong Form';
			else if ('form' in F) F = F.form;
			//
			for (var V = ('elements' in F) ? F.elements : [], i = 0; i < V.length; i++)
			{
				if (active === false) ;
				else if (V[i].disabled) continue;
				//else if (V[i].readonly) continue;
				else if (!String(V[i].tagName).match(/^(button|input|select|textarea)$/ig)) continue;
				else if (String(V[i].tagName).match(/^input$/ig))
				{
					if (String(V[i].type).match(/^(button|file|image|reset|submit)$/ig)) continue;
					else if (String(V[i].type).match(/^(checkbox|radio)$/ig) && !V[i].checked) continue;
				}
				result[result.length] = V[i];
			}
		}
		catch (e) { result = []; }
		return result;
	}
	FORM_SUBMIT = function (data)
	{
		if (!isObject(data) || !('form' in data)) return false;
		var F = (typeof data.form === 'string') ? document.getElementById(data.form) : data.form;
		for (var C = FORM_ELEMENTS(F, true), i = 0, c; i < C.length; i++) { C[i] = [C[i].name, C[i].value]; }
		if (String(F.action).length && !('u' in data)) data.u = String(F.action);
		if (String(F.method).length && !('m' in data)) data.m = String(F.method);
		if (('content' in data)) data.content = TO.content(C, []).concat(TO.content(data.content, []));
		else if (('c' in data)) data.c = TO.content(C, []).concat(TO.content(data.c, []));
		else data.content = C;
		return RUN(data);
	}
	// указатель на себя
	var THIS = this;
	this.init = function (data) { return INITIALIZATION(data); }
	this.clone = function () { return new ajaxThread(ajaxId, constantData, false); }
	this.state = function () { return ajaxState; }
	this.free = function (use) { return FREE(use); }
	this.run = function (data) { return RUN(data); }
	this.get = function (data) { return GET(data); }
	this.post = function (data) { return POST(data); }
	this.formElements = function (form, active) { return FORM_ELEMENTS(form, active); }
	this.form = this.formSubmit = function (data) { return FORM_SUBMIT(data); }
	//
	if ((typeof id === 'string') || (id instanceof String)) ajaxId = String(id);
	else if ((typeof id === 'number') || (id instanceof Number)) ajaxId = String(id);
	else ajaxId = '';
	INITIALIZATION(initing);
	if (run && (run === true)) RUN();
}

function ajaxThreads(id, initing)
{
	var ajaxFree, ajaxId, ajaxData, ajaxObjects = [];
	ajaxFree = function ()
	{
		try
		{
			for (var i = 0; i < ajaxObjects.length; i++) { if (ajaxObjects[i].free()) return i; }
			var ajaxIndex = ajaxObjects.length;
			ajaxObjects[ajaxIndex] = new ajaxThread (ajaxId + ajaxIndex, ajaxData, false);
			return ajaxIndex;
		}
		catch (e) { }
	}
	var INITIALIZATION, RUN, GET, POST, FORM_ELEMENTS, FORM_SUBMIT;
	INITIALIZATION = function (data) { for (var i = 0; i < ajaxObjects.length; i++) { ajaxObjects[i].init(data); } ajaxData = data; }
	RUN = function (data) { return ajaxObjects[ajaxFree()].run(data); }
	GET = function (data) { return ajaxObjects[ajaxFree()].get(data); }
	POST = function (data) { return ajaxObjects[ajaxFree()].post(data); }
	FORM_ELEMENTS = function (form, active) { return ajaxObjects[ajaxFree()].formElements(form, active); }
	FORM_SUBMIT = function (data) { return ajaxObjects[ajaxFree()].formSubmit(data); }
	// указатель на себя
	var THIS = this;
	this.init = function (data) { return INITIALIZATION(data); }
	this.clone = function () { return new ajaxThreads(ajaxId, ajaxData); }
	this.run = function (data) { return RUN(data); }
	this.get = function (data) { return GET(data); }
	this.post = function (data) { return POST(data); }
	this.formElements = function (form, active) { return FORM_ELEMENTS(form, active); }
	this.form = this.formSubmit = function (data) { return FORM_SUBMIT(data); }
	//
	if ((typeof id === 'string') || (id instanceof String)) ajaxId = String(id);
	else if ((typeof id === 'number') || (id instanceof Number)) ajaxId = String(id);
	else ajaxId = '';
	INITIALIZATION(initing);
}

try
{
	var Ajax = new ajaxThreads('AJAX-');
	//document.prototype.Ajax = Ajax;
	//document.Ajax = Ajax;
	//window.Ajax = Ajax;
}
catch (e)
{
	var Ajax = {};
}

// -->