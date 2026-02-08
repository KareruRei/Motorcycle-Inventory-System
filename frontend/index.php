<?php
include "../data/db.php";

$cities = [
    "Abra","Agusan del Norte","Agusan del Sur","Aklan","Albay","Antique","Apayao","Aurora",
    "Basilan","Bataan","Batanes","Batangas","Benguet","Biliran","Bohol","Bukidnon","Bulacan",
    "Cagayan","Camarines Norte","Camarines Sur","Camiguin","Capiz","Catanduanes","Cavite","Cebu",
    "Cotabato","Davao de Oro","Davao del Norte","Davao del Sur","Davao Occidental","Davao Oriental",
    "Dinagat Islands","Eastern Samar","Guimaras","Ifugao","Ilocos Norte","Ilocos Sur","Iloilo",
    "Isabela","Kalinga","La Union","Laguna","Lanao del Norte","Lanao del Sur","Leyte","Maguindanao",
    "Marinduque","Masbate","Metro Manila","Misamis Occidental","Misamis Oriental","Mountain Province",
    "Negros Occidental","Negros Oriental","Northern Samar","Nueva Ecija","Nueva Vizcaya","Occidental Mindoro",
    "Oriental Mindoro","Palawan","Pampanga","Pangasinan","Quezon","Quirino","Rizal","Romblon",
    "Samar","Sarangani","Siquijor","Sorsogon","South Cotabato","Southern Leyte","Sultan Kudarat","Sulu",
    "Surigao del Norte","Surigao del Sur","Tarlac","Tawi-Tawi","Zambales","Zamboanga del Norte",
    "Zamboanga del Sur","Zamboanga Sibugay","Baguio","Cebu City","Davao City","Iloilo City","Cagayan de Oro",
    "Zamboanga City","Tagaytay","Bacolod"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Engine Search V.1.0</title>

  <link href="https://api.fontshare.com/v2/css?f[]=satoshi@900,700,500,300,400&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['Satoshi', 'sans-serif'] },
          colors: { brand: { offwhite: '#F9F9F9', darkgray: '#1A1A1A' } }
        }
      }
    }
  </script>

  <style type="text/tailwindcss">
    @layer utilities {
      .no-scrollbar::-webkit-scrollbar { display: none; }
      .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
      .glass-card { @apply bg-white border border-gray-200 shadow-xl shadow-gray-200/40; }

      .ts-control { @apply !bg-gray-50 !border-gray-200 !rounded-xl !p-3 !text-xs !min-h-[44px] !shadow-none !font-bold; }
      .ts-dropdown { @apply !rounded-xl !shadow-2xl !border-gray-100 !text-xs; }

      .modal-animate { animation: slideUp 0.3s ease-out; }
      @keyframes slideUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    }
  </style>
</head>
<body class="bg-brand-offwhite text-brand-darkgray h-screen overflow-hidden flex flex-col no-scrollbar">

<div class="max-w-7xl mx-auto w-full px-6 flex flex-col h-full py-8">

  <header class="flex justify-between items-end mb-8 shrink-0">
    <div>
      <h1 class="text-4xl font-black tracking-tighter uppercase">Engine <span class="text-gray-400">Search</span></h1>
      <p class="text-gray-400 font-bold text-[10px] uppercase tracking-[0.2em] mt-1">Inventory Management System</p>
    </div>
    
    <div class="flex items-center gap-3">
        <button onclick="openSettings()" class="p-3 text-gray-400 hover:text-brand-darkgray transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </button>
        <button onclick="openModal()" class="bg-brand-darkgray hover:bg-black text-brand-offwhite font-black px-6 py-3 rounded-xl transition-all active:scale-95 shadow-lg text-[10px] uppercase tracking-widest flex items-center gap-2">
          <span class="text-lg leading-none">+</span> Add New Unit
        </button>
    </div>
  </header>

  <div class="relative mb-6 shrink-0">
    <input type="text" id="search" placeholder="Search by model, engine, or location..." class="w-full px-6 py-4 bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-gray-100 outline-none text-sm font-medium transition-all" />
  </div>

  <div class="glass-card rounded-[2.5rem] overflow-hidden flex flex-col grow mb-4">
    <div class="shrink-0 bg-gray-50/80 border-b border-gray-100">
      <table class="w-full text-left table-fixed">
        <thead>
          <tr class="text-gray-400 text-[9px] uppercase tracking-[0.2em] font-black">
            <th class="px-8 py-5 w-1/4">Engine / Model</th>
            <th class="px-4 py-5 text-center">Color</th>
            <th class="px-4 py-5 text-center">Arrival</th>
            <th class="px-4 py-5">Logistics Area</th>
            <th class="px-8 py-5 text-right w-1/5">Status</th>
          </tr>
        </thead>
      </table>
    </div>

    <div class="overflow-y-auto grow no-scrollbar bg-white">
      <table class="w-full text-left table-fixed">
        <tbody id="table-body" class="divide-y divide-gray-50 text-[11px]"></tbody>
      </table>
    </div>
  </div>
</div>

<div id="settingsModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-6 bg-black/10 backdrop-blur-sm">
  <div class="bg-white w-full max-w-xs rounded-[2rem] p-8 modal-animate shadow-2xl border border-gray-100 text-center">
    <div class="w-16 h-16 bg-brand-offwhite rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
        <svg class="w-8 h-8 text-brand-darkgray" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
        </svg>
    </div>
    <h3 class="text-lg font-black uppercase tracking-tighter">Engine Search</h3>
    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1 mb-6">Prototype V.1.0 of the actual</p>
    
    <div class="space-y-3">
        <a href="https://github.com/KareruRei/Motorcycle-Inventory-System" target="_blank" class="block w-full bg-brand-darkgray text-white text-[10px] font-black uppercase py-3 rounded-xl tracking-widest hover:bg-black transition-all">
            GitHub Repository
        </a>
        <button onclick="closeSettings()" class="block w-full text-gray-400 text-[10px] font-black uppercase py-3 tracking-widest hover:text-brand-darkgray">
            Close Panel
        </button>
    </div>
  </div>
</div>

<div id="addModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-6 bg-black/10 backdrop-blur-sm">
  <div class="bg-white w-full max-w-md rounded-[2.5rem] p-10 modal-animate shadow-2xl border border-gray-100">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-black tracking-tighter uppercase">New Unit</h2>
      <button onclick="closeModal()" class="text-gray-300 hover:text-gray-600 font-bold text-xl">✕</button>
    </div>

    <form id="addForm" class="space-y-4">
      <div class="grid grid-cols-2 gap-3">
        <div class="space-y-1">
          <label class="text-[9px] font-black uppercase text-gray-400 ml-1">Model</label>
          <select name="model" class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl text-xs font-bold focus:ring-2 focus:ring-gray-200 outline-none" required>
            <option value="TC125">TC125</option><option value="TC150">TC150</option>
            <option value="MP100">MP100</option><option value="MP110">MP110</option>
            <option value="RAVEN125">RAVEN125</option><option value="MP125">MP125</option>
            <option value="BOLT110">BOLT110</option><option value="BOLT125">BOLT125</option>
            <option value="FLAIR125">FLAIR125</option>
          </select>
        </div>
        <div class="space-y-1">
          <label class="text-[9px] font-black uppercase text-gray-400 ml-1">Color</label>
          <select name="color" class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl text-xs font-bold focus:ring-2 focus:ring-gray-200 outline-none" required>
            <option value="Red">RED</option><option value="Blue">BLUE</option>
            <option value="Black">BLACK</option><option value="White">WHITE</option>
            <option value="Green">GREEN</option><option value="Yellow">YELLOW</option>
          </select>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div class="space-y-1">
          <label class="text-[9px] font-black uppercase text-gray-400 ml-1">Date of Arrival</label>
          <input type="date" name="date_of_arrival" class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl text-xs font-bold" required>
        </div>
        <div class="space-y-1">
          <label class="text-[9px] font-black uppercase text-gray-400 ml-1">Date Sent Out</label>
          <input type="date" name="date_sent_out" class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl text-xs font-bold" required>
        </div>
      </div>

      <div class="space-y-1">
        <label class="text-[9px] font-black uppercase text-gray-400 ml-1">Delivery Area</label>
        <select id="delivery_area" name="delivery_area" required>
          <option value="">Select City</option>
          <?php foreach($cities as $city) echo "<option value=\"$city\">$city</option>"; ?>
        </select>
      </div>

      <div class="space-y-1">
        <label class="text-[9px] font-black uppercase text-gray-400 ml-1">Location of Clearance</label>
        <select id="location_of_clearance" name="location_of_clearance" required>
          <option value="">Select Hub</option>
          <?php foreach($cities as $city) echo "<option value=\"$city\">$city</option>"; ?>
        </select>
      </div>

      <button type="submit" class="w-full bg-brand-darkgray hover:bg-black text-white font-black uppercase py-4 rounded-2xl shadow-xl transition-all active:scale-95 mt-4 text-[10px] tracking-[0.2em]">
        Confirm Registration
      </button>
    </form>
  </div>
</div>

<script>
const API_URL = "../backend/rest.php";

function openModal() { document.getElementById('addModal').classList.remove('hidden'); }
function closeModal() { document.getElementById('addModal').classList.add('hidden'); }

function openSettings() { document.getElementById('settingsModal').classList.remove('hidden'); }
function closeSettings() { document.getElementById('settingsModal').classList.add('hidden'); }

new TomSelect("#delivery_area", { create: false });
new TomSelect("#location_of_clearance", { create: false });

async function fetchMotorcycles(query = "") {
    try {
        const res = await fetch(API_URL + (query ? `?search=${encodeURIComponent(query)}` : ""));
        const data = await res.json();
        const tbody = document.getElementById("table-body");
        tbody.innerHTML = "";

        if(!data.length) {
            tbody.innerHTML = `<tr class="border-b"><td colspan="5" class="p-6 text-center text-gray-400 text-xs uppercase font-bold tracking-widest">No matching units found</td></tr>`;
            return;
        }

        data.forEach(m => {
            const isSent = m.date_sent_out && m.date_sent_out !== '0000-00-00' && m.date_sent_out !== '';
            tbody.innerHTML += `
            <tr class="hover:bg-gray-50/80 transition-all border-b border-gray-50">
              <td class="px-8 py-6 w-1/4">
                <div class="font-black text-brand-darkgray text-xs uppercase tracking-tighter">${m.model}</div>
                <div class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">#${m.engine_number}</div>
              </td>
              <td class="px-4 py-6 text-center text-gray-500 font-black uppercase text-[9px] tracking-widest">${m.color}</td>
              <td class="px-4 py-6 text-center text-gray-400 font-bold italic">${m.date_of_arrival}</td>
              <td class="px-4 py-6">
                <div class="text-gray-600 font-black uppercase text-[10px] tracking-tight leading-tight">${m.delivery_area}</div>
                <div class="text-gray-300 text-[9px] uppercase italic mt-0.5">${m.location_of_clearance}</div>
              </td>
              <td class="px-8 py-6 text-right w-1/5">
                <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest ${isSent ? 'bg-gray-100 text-gray-400' : 'bg-brand-darkgray text-white shadow-md'}">
                  ${isSent ? 'Dispatched' : 'In Facility'}
                </span>
              </td>
            </tr>`;
        });
    } catch(e) { console.error(e); }
}

let timeout;
document.getElementById("search").addEventListener("input", e => {
    clearTimeout(timeout);
    timeout = setTimeout(() => fetchMotorcycles(e.target.value), 300);
});

fetchMotorcycles();

document.getElementById("addForm").addEventListener("submit", async e => {
    e.preventDefault();
    const formData = Object.fromEntries(new FormData(e.target).entries());

    try {
        const res = await fetch(API_URL, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(formData)
        });

        const data = await res.json();
        if(data.status === "success") {
            closeModal();
            fetchMotorcycles();
            e.target.reset();
        } else {
            alert("Error: " + data.message);
        }
    } catch(err) { console.error(err); }
});
</script>

</body>
</html>