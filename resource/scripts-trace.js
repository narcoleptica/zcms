<!--

function trace(data, type, iteration)
{
	var S = [], T = (Boolean(type) || (type === undefined)) ? true : Boolean(type), I = (iteration > 0) ? Number(iteration) : 0;
	var repeat = function (t, n) { var s = ''; for (var i = 0; i < n; i++) s += t; return s; }
	var s = function (i, s, t) { S[S.length] = repeat(' ', i) + t + s; };
	var ss = function (i, ss, t) { s(i, ss, (T && t) ? ('(' + t + ') ') : ''); };
	try
	{
		if (data === null) ss(I, 'NULL', 'null');
		else if ((typeof data === 'boolean') || (data instanceof Boolean)) ss(I, data ? 'TRUE' : 'FALSE', 'boolean');
		else if ((typeof data === 'string') || (data instanceof String)) ss(I, "'" + String(data) + "'", 'string');
		else if ((typeof data === 'number') || (data instanceof Number)) ss(I, "'" + String(data) + "'", 'number');
		else if (data instanceof Array)
		{
			ss(I, '[' + data.length + ']', 'array');
			ss(I, '{', false);
			for (var O = data, o = 0; o < O.length; o++) ss(0, trace(O[o], T, I + 1), false);
			ss(I, '}', false);
		}
		else if ((typeof data === 'object') && data && (data instanceof Object))
		{
			var O = data;
			ss(I, '', 'object');
			ss(I, '{', false);
			for (o in O)
			{
				var oo = trace(O[o], T, I + 1);
				oo = String(oo).trim();
				ss(I + 1, o + ': ' + oo, false);
			}
			ss(I, '}', false);
		}
		else if ((typeof data === 'function') || (data instanceof Function))
		{
			var O = String(data).replace(/^function[\s]*/i, ''), L = 50, l = (O.length > L), o = O.replace(/[\s]+/g, ' ').substr(0, L).trim();
			o = "'" + ((l) ? (o + ' ...') : o) + "'";
			ss(I, o, 'function');
		}
		else ss(I, '', 'unknowen');
	}
	catch (e) { ss(I, '', 'exception'); }
	return S.join("\n");
}

//-->