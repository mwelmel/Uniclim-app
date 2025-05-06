const popup = document.getElementById("calculatorPopup");
const openBtn = document.getElementById("openCalculator");
const closeBtn = document.getElementById("closePopup");

let activeInput = "input1";

openBtn.addEventListener("click", () => popup.classList.remove("hidden"));
closeBtn.addEventListener("click", () => popup.classList.add("hidden"));

const input1 = document.getElementById("input1");
const input2 = document.getElementById("input2");
const result = document.getElementById("result");

input1.addEventListener("focus", () => activeInput = "input1");
input2.addEventListener("focus", () => activeInput = "input2");

function appendNumber(num) {
  const input = document.getElementById(activeInput);
  input.value += num;
}

function deleteNumber() {
  const input = document.getElementById(activeInput);
  input.value = input.value.slice(0, -1);
}

function clearInputs() {
  input1.value = "";
  input2.value = "";
  result.value = "";
}

function calculate() {
  const val1 = parseFloat(input1.value) || 0;
  const val2 = parseFloat(input2.value) || 0;
  result.value = val1 * val2;
}
