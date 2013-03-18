<!--

/** /
	var timer = {
		( wait | w )  :  ( int | null = defaultData.wait:1000 )
		( term | t | cycle )  :  ( string | array | object:{ value: string, count: string } | null = defaultData.term )
		( sapn | s | period | p )  :  ( int | null = defaultData.span:false )
		( call | func | f )  :  ( funciton | null = defaultData.call )
		// function
		( debug )  :  ( funciton | null = defaultData.onDebug )
		( error | e )  :  ( funciton | null = defaultData.onError )
		( start )  :  ( funciton | null = defaultData.onStart )
		( stop )  :  ( funciton | null = defaultData.onStop )
	};
	var Timer = new timerThread(timer);
	Timer.run(timer);
/**/

function timerThread(id, initing, run)
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
	//
	var TO, dataKVdata;
	TO =
	{
		wait: function (data, defaultReturn)
		{
			if (data === false) return 0;
			else if (data === true) return 1000;
			else if (String(data).match(/^[\d]+$/) && (Number(data) >= 0)) return data;
			else return defaultReturn;
		},
		term: function (data, defaultReturn)
		{
			var dataNew = cloneObject(defaultReturn);
			if (isString(data))
			{
				var RE = [/^[\d]+$/, /^([\d]+)[\s]+([\d]+)$/];
				if (String(data).match(RE[0])) { var v = Number(data); if (v >= 0) dataNew.value = v; }
				else if (String(data).match(RE[1]))
				{
					var v = Number(data.replace(RE[1], '$1')), c = Number(data.replace(RE[1], '$2'));
					if (v >= 0) dataNew.value = v;
					if (c >= 0) dataNew.count = c;
				}
			}
			else if (isArray(data))
			{
				var RE = /^[\d]+$/, v, c;
				if (data.length > 0) { v = data[0]; if (String(v).match(RE)) v = Number(v); else if (v === false) v = false; else v = dataNew.value; }
				if (data.length > 1) { c = data[1]; if (String(c).match(RE)) c = Number(c); else if (c === false) c = false; else c = dataNew.count; }
				if (v >= 0) { dataNew.value = v; dataNew.count = (c >= 0) ? c : false; } else dataNew.value = dataNew.count = false;
			}
			else if (isObject(data))
			{
				var RE = /^[\d]+$/, v, c;
				if ('value' in data) v = data.value; else if ('val' in data) v = data.val; else if ('v' in data) v = data.v; else v = null;
				if (String(v).match(RE)) v = Number(v); else if (v === false) v = false; else v = dataNew.value;
				if ('count' in data) c = data.count; else if ('c' in data) c = data.c; else if ('amount' in data) c = data.amount; else c = null;
				if (String(c).match(RE)) c = Number(c); else if (c === false) c = false; else c = dataNew.count;
				if (v >= 0) { dataNew.value = v; dataNew.count = (c >= 0) ? c : false; } else dataNew.value = dataNew.count = false;
			}
			return dataNew;
		},
		span: function (data, defaultReturn)
		{
			if (data === false) return false;
			else if (String(data).match(/^[\d]+$/) && (Number(data) > 0)) return data;
			else return defaultReturn;
		},
		call: function (data, defaultReturn) { if (isFunction(data)) return data; else if (data === false) return false; else return defaultReturn; },
		func: function (data, defaultReturn) { return isFunction(data) ? data : defaultReturn; }
	};
	dataKVdata = function (data, variable, constant)
	{
		data = isObject(data) ? data : { call: data };
		// wait
		if ('wait' in data) variable.wait = TO.wait(data.wait, constant.wait);
		else if ('w' in data) variable.wait = TO.wait(data.w, constant.wait);
		else if ('delay' in data) variable.wait = TO.wait(data.delay, constant.wait);
		else if ('d' in data) variable.wait = TO.wait(data.d, constant.wait);
		else variable.wait = TO.wait('', constant.wait);
		// term
		// delete variable.term;
		if ('term' in data) variable.term = TO.term(data.term, constant.term);
		else if ('t' in data) variable.term = TO.term(data.t, constant.term);
		else if ('cycle' in data) variable.term = TO.term(data.cycle, constant.term);
		else variable.term = TO.term('', constant.term);
		// span
		if ('span' in data) variable.span = TO.span(data.span, constant.span);
		else if ('s' in data) variable.span = TO.span(data.s, constant.span);
		else if ('period' in data) variable.span = TO.span(data.period, constant.span);
		else if ('p' in data) variable.span = TO.span(data.p, constant.span);
		else variable.span = TO.span('', constant.span);
		// call
		if ('call' in data) variable.call = TO.call(data.call, constant.call);
		else if ('func' in data) variable.call = TO.call(data.func, constant.call);
		else if ('f' in data) variable.call = TO.call(data.f, constant.call);
		else variable.call = TO.call(null, constant.call);
		// onDebug
		if ('debug' in data) variable.onDebug = (data.debug === true) ? data.debug : TO.func(data.debug, constant.onDebug);
		else variable.onDebug = TO.func(null, constant.onDebug);
		// onError
		if ('error' in data) variable.onError = TO.func(data.error, constant.onError);
		else if ('e' in data) variable.onError = TO.func(data.e, constant.onError);
		else variable.onError = TO.func(null, constant.onError);
		// onStart
		if ('start' in data) variable.onStart = TO.func(data.start, constant.onStart);
		else variable.onStart = TO.func(null, constant.onStart);
		// onStop
		if ('stop' in data) variable.onStop = TO.func(data.stop, constant.onStop);
		else variable.onStop = TO.func(null, constant.onStop);
	}
	//
	var timerId, timerObject = false, timerState = false, defaultData, constantData, variableData;
	defaultData =
	{
		wait: 1000,
		term: { value: false, count: false },
		span: false,
		call: false,
		onDebug: false,
		onError: false,
		onStart: false,
		onStop: false
	};
	constantData = cloneObject(defaultData, 0xFF, true);
	variableData = cloneObject(constantData, 0xFF, true);
	//
	var DEBUG, ERROR, STARTING, STOPING;
	DEBUG = function (text) { var o = variableData; if (isFunction(o.onDebug)) o.onDebug(text); else if (o.onDebug) alert(text); }
	ERROR = function () { try { var o = variableData; if (isFunction(o.onError)) o.onError(timerState); } catch(e) { DEBUG('Error: timer[' + timerId + '].error.'); } }
	STARTING = function () { try { var o = variableData; if (isFunction(o.onStart)) o.onStart(timerId); } catch(e) { DEBUG('Error: timer[' + timerId + '].start.'); } }
	STOPING = function () { try { var o = variableData; if (isFunction(o.onStop)) o.onStop(timerId); } catch(e) { DEBUG('Error: timer[' + timerId + '].stop.'); } }
	//
	var freeUse = false, FREE, SET, ISET, UNSET;
	FREE = function (use)
	{
		if (freeUse === true) return false;
		else if (use === true) freeUse = true;
		return Boolean(timerState) ? false : true;
	}
	SET = function (call, delay) { freeUse = timerState = true; timerObject = window.setTimeout(call, delay); }
	ISET = function (call, delay) { freeUse = timerState = true; timerObject = window.setInterval(call, delay); }
	UNSET = function () { try { window.clearTimeout(timerObject); } catch (e) { } freeUse = timerObject = timerState = false; }
	//
	var INITIALIZATION, RUN, STOP, START, CALL, ICALL, timerCounter = 0;
	INITIALIZATION = function (data) { dataKVdata(data, constantData, defaultData); dataKVdata(data, variableData, constantData); }
	RUN = function (data) { dataKVdata(data, variableData, constantData); STOP(); return START() ? true : false; }
	STOP = function () { UNSET(); return true; }
	START = function ()
	{
		try
		{
			if (!isFunction(variableData.call)) throw 'Debug: timer[' + timerId + '].start. call invalid';
			var w = (variableData.wait >= 0) ? variableData.wait : 100;
			timerCounter = 0;
			if (variableData.span > 0) SET(ICALL, w)
			else if (variableData.term.value >= 0) (variableData.term.count === false) || (variableData.term.count > 0) ? SET(CALL, w) : 0;
			else throw 'Debug: timer[' + timerId + '].start. unknown';
			return true;
		}
		catch (E)
		{
			STOP();
			DEBUG(E.message);
		}
		return false;
	}
	CALL = function ()
	{
		try
		{
			if (timerCounter === 0) STARTING();
			DEBUG('Debug: timer[' + timerId + '].call. #' + timerCounter);
			var result = variableData.call(timerCounter, timerId);
			if (result === false)
			{
				STOP();
				STOPING();
				DEBUG('Debug: timer[' + timerId + '].call. #' + timerCounter + ' break');
			}
			else
			{
				if (variableData.term.count !== false)
				{
					if (variableData.term.count > 1) variableData.term.count--;
					else throw '#' + timerCounter + ' done';
				}
				if (variableData.term.value >= 0) SET(CALL, variableData.term.value);
				timerCounter++;
			}
		}
		catch (E)
		{
			STOP();
			STOPING();
			DEBUG('Debug: timer[' + timerId + '].call. ' + E.message);
		}
	}
	ICALL = function ()
	{
		if (variableData.span !== false)
		{
			STOP();
			var span = variableData.span;
			variableData.span = false;
			ISET(ICALL, span);
			STARTING();
		}
		try
		{
			var result = variableData.call(timerCounter, timerId);
			if (result === false)
			{
				STOP();
				STOPING();
				DEBUG('Debug: timer[' + timerId + '].icall. #' + timerCounter + ' break');
			}
			timerCounter++;
		}
		catch (E)
		{
			STOP();
			STOPING();
			DEBUG('Debug: timer[' + timerId + '].call. ' + E.message);
		}
	}
	// указатель на себя
	var THIS = this;
	this.init = function (data) { return INITIALIZATION(data); }
	this.clone = function () { return new timerThread(timerId, constantData, false); }
	this.state = function () { return timerState; }
	this.free = function () { return FREE(); }
	this.run = function (data) { return RUN(data); }
	this.stop = function () { return STOP(); }
	//
	if ((typeof id === 'string') || (id instanceof String)) timerId = String(id);
	else if ((typeof id === 'number') || (id instanceof Number)) timerId = String(id);
	else timerId = '';
	INITIALIZATION(initing);
	if (run && (run === true)) RUN();
}

function timerThreads(id, initing)
{
	var timerFree, timerId, timerData, timerObjects = [];
	timerFree = function ()
	{
		try
		{
			for (var i = 0; i < timerObjects.length; i++) { if (timerObjects[i].free()) return i; }
			var timerIndex = timerObjects.length;
			timerObjects[timerIndex] = new timerThread (timerId + timerIndex, timerData, false);
			return timerIndex;
		}
		catch (e) { }
	}
	var INITIALIZATION, RUN;
	INITIALIZATION = function (data) { for (var i = 0; i < timerObjects.length; i++) { timerObjects[i].init(data); } timerData = data; }
	RUN = function (data) { var index = timerFree(); return timerObjects[index].run(data) ? index : false; }
	STOP = function (index) { try { return timerObjects[index].stop(); } catch (e) { return false; } }
	// указатель на себя
	var THIS = this;
	this.init = function (data) { return INITIALIZATION(data); }
	this.clone = function () { return new timerThreads(timerId, timerData); }
	this.run = function (data) { return RUN(data); }
	this.stop = function (index) { return STOP(index); }
	//
	if ((typeof id === 'string') || (id instanceof String)) timerId = String(id);
	else if ((typeof id === 'number') || (id instanceof Number)) timerId = String(id);
	else timerId = '';
	INITIALIZATION(initing);
}

try
{
	var Timer = new timerThreads('TIMER-');
	//document.prototype.Timer = Timer;
	//document.Timer = Timer;
	//window.Timer = Timer;
}
catch (e)
{
	var Timer = {};
}

//-->