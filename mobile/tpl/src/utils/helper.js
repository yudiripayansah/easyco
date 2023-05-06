const thousand = (num) => {
  if (num) {
    let num_parts = num.toString().split(",");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return num_parts.join(",");
  } else {
    return 0
  }
}
const thousandMask = (num) => {
  if (num) {
    let num_parts = num.toString().split(",");
    num_parts[0] = num_parts[0].replace(/\./g,'')
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return [num_parts.join(",")];
  } else {
    return [0]
  }
}
const removeThousand = (num) => {
  if (num) {
    let num_parts = num.toString().split(",");
    num_parts[0] = num_parts[0].replace(/\./g,'')
    return num_parts.join(",");
  } else {
    return 0
  }
}

const today = () => {
  const date = new Date();
  let day = date.getDate();
  let month = date.getMonth() + 1;
  let year = date.getFullYear();
  let currentDate = `${day}/${month}/${year}`;
  return currentDate
}

export default { thousand, thousandMask, removeThousand, today }