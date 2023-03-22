// เลือก DOM elements ที่เป็น draggables และ droppables
const draggables = document.querySelectorAll(".task");
const droppables = document.querySelectorAll(".swim-lane");


// เพิ่ม event listeners สำหรับ drag and drop ในทุก draggables
draggables.forEach((task) => {
  task.addEventListener("dragstart", (ev) => {
    task.classList.add("is-dragging");

  });
  task.addEventListener("dragend", (ev) => {
    task.classList.remove("is-dragging");
    console.log(task.textContent + ' ==> '+ task.parentElement.textContent.split('\n')[1]);
    checktable();
  });
});

// เพิ่ม event listeners สำหรับ dragover ในทุก droppables
droppables.forEach((zone) => {
  zone.addEventListener("dragover", (e) => {
    e.preventDefault(); // หยุดการกระทำของ event เดิม
    
    const bottomTask = insertAboveTask(zone, e.clientY); // เรียกใช้ฟังก์ชัน insertAboveTask เพื่อหา task ที่อยู่ด้านล่างสุด
    const curTask = document.querySelector(".is-dragging"); // หา DOM element ที่กำลังถูกลาก
    const parentZone = curTask.parentElement; // หา parent element ของ curTask


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
  var tasks = document.querySelectorAll(".swim-lane");
  tasks.forEach((task) => {
    var taskhead = task.textContent;
    var arTask = taskhead.split('\n')
    var cuttask = arTask.slice(2).map((item) => item.trim()).join(', ');
    var headdingRole = taskhead.split('\n')[1].trim()
    
    if (headdingRole === 'Rank 1'){
      console.log(cuttask);
      if (cuttask.includes('Road locations')) {
        
      }
      if (cuttask.includes('Water locations')) {
        
      }
      if (cuttask.includes('School locations')) {
        
      }
    }
    if (headdingRole === 'Rank 2'){
      console.log(cuttask);
      if (cuttask.includes('Road locations')) {
        
      }
      if (cuttask.includes('Water locations')) {
        
      }
      if (cuttask.includes('School locations')) {
        
      }
    }
    if (headdingRole === 'Rank 3'){
      console.log(cuttask);
      if (cuttask.includes('Road locations')) {
        
      }
      if (cuttask.includes('Water locations')) {
        
      }
      if (cuttask.includes('School locations')) {
        
      }
    }
    if (headdingRole === 'Role') {
      // more code for Role 
    }
  });
}

function updatepopup(text) {
  var popup = document.querySelectorAll('div.popup')
}

