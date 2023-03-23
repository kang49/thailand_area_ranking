// เลือก DOM elements ที่เป็น draggables และ droppables
const draggables = document.querySelectorAll(".task");
const droppables = document.querySelectorAll(".swim-lane");

const info1 = document.querySelector(".info1");
const info2 = document.querySelector(".info2");
const info3 = document.querySelector(".info3");

// เพิ่ม event listeners สำหรับ drag and drop ในทุก draggables
document.addEventListener("DOMContentLoaded", () => {
  // เพิ่ม event listeners สำหรับ drag and drop ในทุก draggables
  draggables.forEach(task => {
    task.addEventListener("dragstart", ev => {
      task.classList.add("is-dragging");
    });

    task.addEventListener("dragend", ev => {
      task.classList.remove("is-dragging");
      checktable();
    });
  });
});

// เพิ่ม event listeners สำหรับ dragover ในทุก droppables
droppables.forEach((zone) => {
  zone.addEventListener("dragover", (e) => {
    e.preventDefault(); // หยุดการกระทำของ event เดิม
    
    const bottomTask = insertAboveTask(zone, e.clientY); // เรียกใช้ฟังก์ชัน insertAboveTask เพื่อหา task ที่อยู่ด้านล่างสุด
    const curTask = document.querySelector(".is-dragging"); // หา DOM element ที่กำลังถูกลาก
    const parentZone = curTask.parentElement; // หา parent element ของ curTask
    if (curTask) {
      info1.classList.add("hide");
      info2.classList.add("hide");
      info3.classList.add("hide");
    }

    if (!bottomTask) { // ถ้าไม่มี task ที่อยู่ด้านล่างของ zone
      zone.appendChild(curTask); // เพิ่ม curTask เป็น child ของ zone
    } else { // ถ้ามี task ที่อยู่ด้านล่างของ zone
      zone.insertBefore(curTask, bottomTask); // เพิ่ม curTask เป็น sibling ก่อน bottomTask
    }

    if (parentZone === zone) { // ถ้า curTask อยู่ใน zone เดียวกันกับที่วางลงไป

    } else { // ถ้า curTask ไม่ได้อยู่ใน zone เดียวกันกับที่วางลงไป

    }
  });
});

// ฟังก์ชันสำหรับหา task ที่อยู่ด้านล่างสุดใน zone โดยอ้างอิงจากตำแหน่งของเม้าส์
const insertAboveTask = (zone, mouseY) => {
  const els = zone.querySelectorAll(".task:not(.is-dragging)");

  let closestTask = null;
  let closestOffset = Number.NEGATIVE_INFINITY;

  els.forEach((task) => {
    const { top } = task.getBoundingClientRect(); // หาค่า top ของ task
    const offset = mouseY - top; // คำนวณหาค่า offset ของ task ที่อยู่ใกล้ที่สุดกับเม้าส์

    if (offset < 0 && offset > closestOffset) { // ถ้า offset น้อยกว่า 0 และมากกว่า closestOffset
      closestOffset = offset;
      closestTask = task;
    }

  });
  return closestTask;
};

function checktable () {
  var rank1_obj = [];
  var rank2_obj = [];
  var rank3_obj = [];

  // create an array of swim-lanes
  var swim_lanes = document.querySelectorAll('.swim-lane');

  // loop through each swim-lane and add tasks to the appropriate list
  for (var i = 0; i < swim_lanes.length; i++) {
    var task_head = swim_lanes[i].querySelector('h3.heading').textContent.trim();

    if (task_head === 'First') {
      var rank1_tasks = swim_lanes[i].querySelectorAll('.task');
      for (var j = 0; j < rank1_tasks.length; j++) {
        rank1_obj.push(rank1_tasks[j].textContent.trim());
      }
    } else if (task_head === 'Second') {
      var rank2_tasks = swim_lanes[i].querySelectorAll('.task');
      for (var j = 0; j < rank2_tasks.length; j++) {
        rank2_obj.push(rank2_tasks[j].textContent.trim());
      }
    } else if (task_head === 'Third') {
      var rank3_tasks = swim_lanes[i].querySelectorAll('.task');
      for (var j = 0; j < rank3_tasks.length; j++) {
        rank3_obj.push(rank3_tasks[j].textContent.trim());
      }
    }
  }

  // send the data to the server
  var xhttp = new XMLHttpRequest();
  var form_data = new FormData();
  form_data.append("rank1_obj", JSON.stringify(rank1_obj));
  form_data.append("rank2_obj", JSON.stringify(rank2_obj));
  form_data.append("rank3_obj", JSON.stringify(rank3_obj));
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
    }
  };
  xhttp.open("POST", "ranking_gen.php");
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  var form_data = "rank1_obj=" + JSON.stringify(rank1_obj) + "&rank2_obj=" + JSON.stringify(rank2_obj) + "&rank3_obj=" + JSON.stringify(rank3_obj);
  xhttp.send(form_data);
}


function updatepopup(text) {
  var popup = document.querySelectorAll('div.popup')
}

