const thousand = (num) => {
  if (num) {
    let num_parts = num.toString().split(".");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return num_parts.join(",");
  } else {
    return 0
  }
}
const thousandMask = (num) => {
  if (num) {
    let num_parts = num.toString().split(",");
    num_parts[0] = num_parts[0].replace(/\./g, '')
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return [num_parts.join(",")];
  } else {
    return [0]
  }
}
const removeThousand = (num) => {
  if (num) {
    let num_parts = num.toString().split(",");
    num_parts[0] = num_parts[0].replace(/\./g, '')
    return num_parts.join(",");
  } else {
    return 0
  }
}

const dateFormatId = (date, sepparator = '-') => {
  if (date) {
    let theDate = new Date(date)
    let d = theDate.getDate()
    let m = theDate.getMonth() + 1
    let y = theDate.getFullYear()
    return `${d}${sepparator}${m}${sepparator}${y}`
  } else {
    return null
  }
}

const maxLength = (s, l) => {
  return String(s).substring(0, l);
}

/**
 * @author Irham C. <icip1998@gmail.com>
 * @created at 2023-09-09
 * @param {*} number 
 * @param {*} decimals 
 * @param {*} dec_point 
 * @param {*} thousands_sep 
 * @returns string
 */
const numberFormat = (number = 0, decimals = 2, dec_point = ',', thousands_sep = '.') => {
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  // Add this number to the element as text.
  return s.join(dec);
}

export default {
  thousand,
  thousandMask,
  removeThousand,
  dateFormatId,
  maxLength,
  numberFormat
}