(function($) {
	$.fn.wtbox_calender = function(options) {
		var settings = $.extend({
			sundayOff: null,
			saturdayOff: null,
			pDate: 'default',
			fDate: 'default',
			sMonth: null,
			sYear: null
		}, options)

		return this.each(function() {
			var calHeader = document.createElement('div');
			calHeader.setAttribute('class', 'calender_head bg_theme_2');
			var calenderBox = document.getElementById('wtbox_calender');
			calenderBox.appendChild(calHeader);
			var monthName = document.createElement('span');
			monthName.setAttribute('id', 'myMonth');
			var year = document.createElement('span');
			year.setAttribute('id', 'myYear');
			calHeader.appendChild(monthName);
			calHeader.appendChild(year);
			var prevArrow = document.createElement('span');
			prevArrow.setAttribute('id', 'prevArrow');
			var nextArrow = document.createElement('span');
			nextArrow.setAttribute('id', 'nextArrow');
			calHeader.appendChild(prevArrow);
			calHeader.appendChild(nextArrow);
			$(prevArrow).html('<');
			$(nextArrow).html('>');
			var dayBox = document.createElement('div');
			dayBox.setAttribute('class', 'dayBox');
			dayBox.setAttribute('id', 'setDays');
			var dayBox2 = dayBox.cloneNode(true);
			dayBox2.setAttribute('id', 'setDates');
			calenderBox.appendChild(dayBox);
			calenderBox.appendChild(dayBox2);

			if (settings.sMonth == null && settings.sYear == null) {
				var curRdate = new Date();
				var curRy = curRdate.getFullYear();
				var curRm = curRdate.getMonth();
				var pm = curRm;
				var pm_1 = pm+1;
				var py = curRy;
				callDates();
			} else {
				var py = settings.sYear;
				var pm_1 = settings.sMonth;
				callDates();
			}

			function callDates() {
				var date = new Date(py, pm_1, 0);
				var y = date.getFullYear();
				var m = date.getMonth();
				var d = date.getDay(); // today
				var dn = date.getDate(); // total days

				months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
				var weeks = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];

				document.getElementById("myMonth").innerText = months[m];
				document.getElementById("myMonth").setAttribute("data-month", ('0' + (m+1)).slice(-2));
				document.getElementById("myYear").innerText = y;
				document.getElementById("myYear").setAttribute("data-year", y);

				var days = document.createElement('div');
				days.setAttribute('class', 'daysName');

				var foo = new Array(7);
				for(var i = 0; i < foo.length; i++){
					var days = days.cloneNode(true);
					dayBox.appendChild(days);
					var str = weeks[i];
					var res = str.substring(0, 3);
					days.innerHTML = res;
				}

				var dates = document.createElement('div');
				dates.setAttribute('class', 'daysDay');
				var mPv = m+Number(1);

				function daysInMonth (month, year) { 
				    return new Date(y, mPv, 0).getDate(); 
				}
				var cnDays = daysInMonth(y, mPv, 0);

				var f = new Date(y, m, 0);
				fDay = f.getDay();

				if (fDay > 4 && cnDays >= 30) {
					var foo = new Array(42);
				} else {
					var foo = new Array(35);
				}

				for(var i = 0; i < foo.length; i++){ 
					var dates = dates.cloneNode(true);
					dayBox2.appendChild(dates);
				}

				if (mPv == 1) {
					var prevM = 12;
					var prevY = y-Number(1);
					function daysInMonth (month, year) { 
					    return new Date(prevY, prevM, 0).getDate(); 
					}
					preVcnDays = daysInMonth(prevY, prevM, 0);

				} else {
					var prevM = mPv-Number(1);
					var prevY = y;
					function daysInMonth (month, year) { 
					    return new Date(prevY, prevM, 0).getDate(); 
					}
					preVcnDays = daysInMonth(prevY, prevM, 0);
				}

				const parentList = document.getElementById('setDates');
				listChildren = parentList.children;

				for (var i = 0; i < cnDays; i++) {
					listChildren[i+fDay].textContent = i+1;
					$(listChildren[i+fDay]).value = py+","+pm_1+","+(i+1);
					listChildren[i+fDay].className += " actDates curr fH-"+y+'-'+('0' + pm_1).slice(-2)+'-'+('0' + (i+1)).slice(-2);
					listChildren[i+fDay].addEventListener("click", selDate);
					listChildren[i+fDay].setAttribute('data-date', y+'-'+('0' + pm_1).slice(-2)+'-'+('0' + (i+1)).slice(-2));
					
					var len = foo.length;
					var nextD = len-(cnDays+fDay);
					for (var j = 0; j < nextD; j++) {
						listChildren[cnDays+fDay+j].textContent = j+1;
					}

					for (var k = 0; k < fDay; k++) {
						listChildren[fDay-k-1].textContent = Math.abs(k-preVcnDays);
					}

				}
				$('.daysDay').append('<span></span>')

				//Options to set
				////////////////////////////////////
				if(settings.sundayOff){
					var mg = 0;
					mg += 7;
					for (var i = 1; i < 6; i++) {
						listChildren[(mg*i)-1].className = listChildren[(mg*i)-1].className.replace( /(?:^|\s)actDates(?!\S)/g , '' );
						listChildren[(mg*i)-1].removeEventListener("click", selDate);
					}
				}
				if(settings.saturdayOff){
					var mg = 0;
					mg += 7;
					for (var i = 1; i < 6; i++) {
						listChildren[(mg*i)-2].className = listChildren[(mg*i)-2].className.replace( /(?:^|\s)actDates(?!\S)/g , '' );
						listChildren[(mg*i)-2].removeEventListener("click", selDate);
					}
				}

				var myM = document.getElementById("myMonth").innerText;
				var myY = document.getElementById("myYear").innerText;
				var xEle = document.getElementById("setDates").querySelectorAll(".curr");

				if(settings.pDate){
					var past = new Date();
					past.setDate(past.getDate() - settings.pDate+1);
					var pMonth = past.getMonth();
					var pDate = past.getDate();
					var pYear = past.getFullYear();

					if (myM == months[pMonth] && myY == pYear) {
						prevArrow.removeEventListener("click", prevDates);
						for (var i = 1; i < pDate+1; i++) {
							xEle[pDate-i].className = xEle[pDate-i].className.replace( /(?:^|\s)actDates(?!\S)/g , '' );
							xEle[pDate-i].removeEventListener("click", selDate);
						}
					} else {
						prevArrow.addEventListener("click", prevDates);
					}
				}

				if(settings.fDate){
					var future = new Date();
					future.setDate(future.getDate() + settings.fDate-1);
					var fMonth = future.getMonth();
					var fDate = future.getDate();
					var fYear = future.getFullYear();
					function daysInMonth (month, year) { 
					    return new Date(fYear, fMonth, 0).getDate(); 
					}
					var pdIm = daysInMonth(fYear, fMonth, 0);

					if (myM == months[fMonth] && myY == fYear) {
						nextArrow.removeEventListener("click", nextDates);
						for (var i = 0; i < pdIm-fDate; i++) {
							xEle[fDate+i].className = xEle[fDate+i].className.replace( /(?:^|\s)actDates(?!\S)/g , '' );
							xEle[fDate+i].removeEventListener("click", selDate);
						}
					} else {
						nextArrow.addEventListener("click", nextDates);
					}
				}

				if (settings.sMonth && settings.sYear) {
					var mPast = new Date(settings.sYear, settings.sMonth, 0);
				}

				gToday();
			}

			//Today Bg//
			function gToday(){
				var tDate = new Date();
				var yD = tDate.getFullYear();
				var mD = tDate.getMonth();
				// var dD = tDate.getDay();
				var dnD = tDate.getDate();
				if(document.getElementById('myMonth').innerText == months[mD] && document.getElementById('myYear').innerText == yD){
					const parentList1 = document.getElementById('setDates');
					listChildren1 = parentList1.children;
					listChildren[dnD+fDay-1].classList.add("gToday");
				}
			}

			function selDate() {
				// alert();
			}

			////////Previous Days, Months & Year Functions
			function prevDates() {
				if(pm_1 == 1){
					pm_1 = 12;
					py = py-1;
				}else{
					pm_1 = pm_1-1;
				}
				// pm_1 = pm_1-1;
				var e = document.querySelector("#setDates"); 
		        //e.firstElementChild can be used. 
		        var child = e.lastElementChild;  
		        while (child) { 
		            e.removeChild(child); 
		            child = e.lastElementChild; 
		        }
		        var e = document.querySelector("#setDays"); 
		        //e.firstElementChild can be used. 
		        var child = e.lastElementChild;  
		        while (child) { 
		            e.removeChild(child); 
		            child = e.lastElementChild; 
		        }
		        
				callDates();
				gHolDays();
				myEvent();
			}

			////////Next Days, Months & Year Functions
			function nextDates() {
				if(pm_1 == 12){
					pm_1 = 1;
					py = py+1;
				}else{
					pm_1 = pm_1+1;
				}
				// pm_1 = pm_1+1;
				var e = document.querySelector("#setDates"); 
		        //e.firstElementChild can be used. 
		        var child = e.lastElementChild;  
		        while (child) { 
		            e.removeChild(child); 
		            child = e.lastElementChild; 
		        }
		        var e = document.querySelector("#setDays"); 
		        //e.firstElementChild can be used. 
		        var child = e.lastElementChild;  
		        while (child) { 
		            e.removeChild(child); 
		            child = e.lastElementChild; 
		        }
				callDates();
				gHolDays();
				myEvent();
			}
		})
	}

}(jQuery));

;
