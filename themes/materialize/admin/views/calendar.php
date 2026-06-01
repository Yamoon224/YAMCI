<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-calendar-event-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('calendar') ?: 'Calendrier'; ?></h4>
    <p class="mb-0 text-muted">Gérez vos événements et rappels.</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('calendar') ?: 'Calendrier'; ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <button type="button" class="btn btn-primary" id="btnNewEvent">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?php echo lang('add_event') ?: 'Nouvel événement'; ?>
    </button>
  </div>
</div>

<!-- FullCalendar v5 (Pixinvent) -->
<link rel="stylesheet" href="<?php echo $assets; ?>vendor/libs/fullcalendar/fullcalendar.css" />
<link rel="stylesheet" href="<?php echo $assets; ?>vendor/libs/flatpickr/flatpickr.css" />

<div class="card">
  <div class="card-body">
    <div id="calendar"></div>
  </div>
</div>

<!-- Event Modal -->
<div class="modal fade" id="calEventModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="calEventModalTitle"><?php echo lang('add_event') ?: 'Ajouter un événement'; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger d-none" id="calEventError"></div>
        <form id="calEventForm">
          <input type="hidden" id="eid" name="eid" value="" />
          <div class="mb-4">
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control" id="title" name="title" placeholder="Titre de l'événement" required />
              <label for="title"><?php echo lang('title') ?: 'Titre'; ?> <span class="text-danger">*</span></label>
            </div>
          </div>
          <div class="row g-4 mb-4">
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="cal_start" name="start" placeholder="Début" required />
                <label for="cal_start"><?php echo lang('start') ?: 'Début'; ?> <span class="text-danger">*</span></label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="cal_end" name="end" placeholder="Fin" />
                <label for="cal_end"><?php echo lang('end') ?: 'Fin'; ?></label>
              </div>
            </div>
          </div>
          <div class="mb-4">
            <label class="form-label mb-2"><?php echo lang('event_color') ?: 'Couleur de l\'événement'; ?></label>
            <div class="d-flex gap-2 flex-wrap" id="colorPalette">
              <?php
              $palette = [
                ['name' => 'Primary', 'value' => '#666cff'],
                ['name' => 'Success', 'value' => '#28c76f'],
                ['name' => 'Info',    'value' => '#00cfe8'],
                ['name' => 'Warning', 'value' => '#ff9f43'],
                ['name' => 'Danger',  'value' => '#ff3e1d'],
                ['name' => 'Dark',    'value' => '#5d596c'],
              ];
              foreach ($palette as $i => $c): ?>
                <button type="button" class="color-swatch <?= $i === 0 ? 'active' : '' ?>"
                        data-color="<?= $c['value'] ?>" title="<?= $c['name'] ?>"
                        style="background:<?= $c['value'] ?>"></button>
              <?php endforeach; ?>
              <input type="hidden" id="color" name="color" value="#666cff" />
            </div>
          </div>
          <div class="mb-3">
            <div class="form-floating form-floating-outline">
              <textarea class="form-control" id="description" name="description" placeholder="Description" style="height: 100px;"></textarea>
              <label for="description"><?php echo lang('description') ?: 'Description'; ?></label>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-between" id="calEventModalFooter">
        <button type="button" class="btn btn-outline-danger d-none" id="deleteEventBtn">
          <i class="ri ri-delete-bin-line me-1"></i><?php echo lang('delete') ?: 'Supprimer'; ?>
        </button>
        <div class="ms-auto d-flex gap-2">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
          <button type="button" class="btn btn-primary" id="saveEventBtn">
            <i class="ri ri-save-line me-1"></i><?php echo lang('save') ?: 'Enregistrer'; ?>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  /* Calendar — Pixinvent polish */
  .fc { --fc-border-color: rgba(75,70,92,0.10); font-family: inherit; }
  .fc .fc-toolbar.fc-header-toolbar { margin-bottom: 1rem; }
  .fc .fc-toolbar-title { font-size: 1.15rem; font-weight: 600; color: var(--bs-heading-color,#5d596c); }
  .fc .fc-button-primary {
    background: var(--bs-secondary-bg-subtle, rgba(75,70,92,0.08));
    color: var(--bs-heading-color, #5d596c);
    border: none;
    box-shadow: none !important;
    font-weight: 500;
    border-radius: 8px;
    padding: .45rem .9rem;
    text-transform: capitalize;
    transition: background .15s ease, color .15s ease;
  }
  .fc .fc-button-primary:hover { background: rgba(102,108,255,0.12); color: #666cff; }
  .fc .fc-button-primary:not(:disabled).fc-button-active,
  .fc .fc-button-primary:not(:disabled):active {
    background: #666cff !important; color: #fff !important;
  }
  .fc .fc-button-group { gap: 4px; }
  .fc .fc-button-group > .fc-button { border-radius: 8px !important; }
  .fc .fc-col-header-cell-cushion { color: var(--bs-secondary-color,#8592a3); font-weight: 600; text-transform: uppercase; font-size: .72rem; letter-spacing: .04em; padding: 8px 4px; text-decoration: none; }
  .fc .fc-daygrid-day-number { color: var(--bs-heading-color,#5d596c); font-weight: 500; padding: 8px; text-decoration: none; }
  .fc .fc-daygrid-day.fc-day-today { background: rgba(102,108,255,0.06) !important; }
  .fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
    background: #666cff; color: #fff; border-radius: 50%; width: 28px; height: 28px;
    display: inline-flex; align-items: center; justify-content: center; padding: 0;
  }
  .fc .fc-event { border-radius: 6px; border: none; padding: 2px 6px; font-size: .78rem; cursor: pointer; box-shadow: 0 1px 3px rgba(75,70,92,.12); }
  .fc .fc-event:hover { transform: translateY(-1px); box-shadow: 0 4px 8px rgba(75,70,92,.18); }
  .fc-event-title { font-weight: 500; }
  .fc .fc-list-day-cushion { background: rgba(102,108,255,0.04); }

  /* Color swatches */
  .color-swatch {
    width: 36px; height: 36px; border-radius: 50%; border: 2px solid transparent;
    padding: 0; cursor: pointer; position: relative;
    transition: transform .12s ease, box-shadow .12s ease;
  }
  .color-swatch:hover { transform: scale(1.08); }
  .color-swatch.active { border-color: rgba(75,70,92,0.4); box-shadow: 0 0 0 3px rgba(102,108,255,0.20); }
  .color-swatch.active::after {
    content: "✓"; color: #fff; font-size: 14px; font-weight: 700;
    position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
  }
</style>

<script src="<?php echo $assets; ?>vendor/libs/fullcalendar/fullcalendar.js"></script>
<script src="<?php echo $assets; ?>vendor/libs/flatpickr/flatpickr.js"></script>

<script>
window.addEventListener('load', function () {
  'use strict';
  // Pixinvent bundle exports window.Calendar / window.dayGridPlugin / window.timegridPlugin /
  // window.listPlugin / window.interactionPlugin (NOT window.FullCalendar).
  if (typeof Calendar === 'undefined') {
    console.error('FullCalendar (window.Calendar) not loaded');
    return;
  }
  if (typeof bootstrap === 'undefined') {
    console.error('Bootstrap not loaded yet');
    return;
  }

  const calEl     = document.getElementById('calendar');
  const modalEl   = document.getElementById('calEventModal');
  const modal     = new bootstrap.Modal(modalEl);
  const errorBox  = document.getElementById('calEventError');
  const titleEl   = document.getElementById('title');
  const startEl   = document.getElementById('cal_start');
  const endEl     = document.getElementById('cal_end');
  const colorEl   = document.getElementById('color');
  const descEl    = document.getElementById('description');
  const eidEl     = document.getElementById('eid');
  const deleteBtn = document.getElementById('deleteEventBtn');
  const saveBtn   = document.getElementById('saveEventBtn');
  const modalTitle = document.getElementById('calEventModalTitle');
  const newBtn   = document.getElementById('btnNewEvent');

  const csrfName  = '<?php echo $this->security->get_csrf_token_name(); ?>';
  const csrfHash  = '<?php echo $this->security->get_csrf_hash(); ?>';
  const url = {
    events: '<?php echo admin_url('calendar/get_events'); ?>',
    add:    '<?php echo admin_url('calendar/add_event'); ?>',
    update: '<?php echo admin_url('calendar/update_event'); ?>',
    del:    '<?php echo admin_url('calendar/delete_event'); ?>'
  };

  // Flatpickr instances — display format matches user's locale (dd/mm/yyyy HH:mm)
  // so that SMA's fld() helper can re-parse it when posting back.
  const fpStart = flatpickr(startEl, { enableTime: true, dateFormat: 'd/m/Y H:i', time_24hr: true, allowInput: true });
  const fpEnd   = flatpickr(endEl,   { enableTime: true, dateFormat: 'd/m/Y H:i', time_24hr: true, allowInput: true });

  // Color palette handler
  document.querySelectorAll('#colorPalette .color-swatch').forEach(function (sw) {
    sw.addEventListener('click', function () {
      document.querySelectorAll('#colorPalette .color-swatch').forEach(s => s.classList.remove('active'));
      sw.classList.add('active');
      colorEl.value = sw.dataset.color;
    });
  });

  function setColorSwatch(hex) {
    let found = false;
    document.querySelectorAll('#colorPalette .color-swatch').forEach(function (sw) {
      if (sw.dataset.color.toLowerCase() === (hex||'').toLowerCase()) {
        sw.classList.add('active'); found = true;
      } else { sw.classList.remove('active'); }
    });
    if (!found && hex) {
      // Fallback: select first
      document.querySelector('#colorPalette .color-swatch')?.classList.add('active');
    }
    colorEl.value = hex || '#666cff';
  }

  function resetForm() {
    eidEl.value = '';
    titleEl.value = '';
    fpStart.clear(); fpEnd.clear();
    descEl.value = '';
    setColorSwatch('#666cff');
    errorBox.classList.add('d-none'); errorBox.textContent = '';
    deleteBtn.classList.add('d-none');
    modalTitle.textContent = '<?php echo addslashes(lang('add_event') ?: 'Ajouter un événement'); ?>';
  }

  function openCreateModal(defaultStart, defaultEnd) {
    resetForm();
    if (defaultStart) fpStart.setDate(defaultStart);
    if (defaultEnd)   fpEnd.setDate(defaultEnd);
    modal.show();
  }

  function openEditModal(evt) {
    resetForm();
    eidEl.value = evt.id;
    titleEl.value = evt.title || '';
    if (evt.start) fpStart.setDate(evt.start);
    if (evt.end)   fpEnd.setDate(evt.end);
    descEl.value = (evt.extendedProps && evt.extendedProps.description) || '';
    setColorSwatch(evt.backgroundColor || evt.color || '#666cff');
    modalTitle.textContent = '<?php echo addslashes(lang('edit_event') ?: 'Modifier l\'événement'); ?>';
    deleteBtn.classList.remove('d-none');
    modal.show();
  }

  // ---- Calendar init ----
  const calendar = new Calendar(calEl, {
    plugins: [ dayGridPlugin, timegridPlugin, listPlugin, interactionPlugin ],
    initialView: 'dayGridMonth',
    headerToolbar: {
      start: 'prev,next today',
      center: 'title',
      end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
    },
    buttonText: {
      today: "Aujourd'hui",
      month: "Mois",
      week:  "Semaine",
      day:   "Jour",
      list:  "Liste"
    },
    locale: '<?php echo $cal_lang ?: 'fr'; ?>',
    firstDay: 1,
    height: 'auto',
    expandRows: true,
    weekNumbers: false,
    dayMaxEvents: 3,
    editable: true,
    selectable: true,
    selectMirror: true,
    nowIndicator: true,
    eventDisplay: 'block',
    displayEventTime: true,
    eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false },

    events: function (info, success, fail) {
      const start = info.startStr.slice(0, 10);
      const end   = info.endStr.slice(0, 10);
      fetch(url.events + '?start=' + start + '&end=' + end, { credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => {
          // SMA's FC2-style payload: id, title, start, end, color, description
          success((data || []).map(e => ({
            id: e.id,
            title: e.title,
            start: e.start,
            end:   e.end,
            backgroundColor: e.color || e.backgroundColor || '#666cff',
            borderColor:     e.color || e.borderColor     || '#666cff',
            extendedProps:   { description: e.description || '' }
          })));
        })
        .catch(err => { console.error(err); fail(err); });
    },

    dateClick: function (info) {
      openCreateModal(info.dateStr, null);
    },
    select: function (info) {
      openCreateModal(info.startStr, info.endStr);
      calendar.unselect();
    },
    eventClick: function (info) {
      openEditModal(info.event);
    },
    eventDrop:   function (info) { quickUpdate(info.event); },
    eventResize: function (info) { quickUpdate(info.event); }
  });

  calendar.render();

  // ---- Save / Update / Delete ----
  function showError(msg) {
    errorBox.textContent = msg || 'Erreur inconnue';
    errorBox.classList.remove('d-none');
  }

  // SMA's fld() helper expects the date in the user's locale (dd/mm/yyyy HH:mm).
  function fmtDate(d) {
    if (!d) return '';
    if (typeof d === 'string') return d;
    const pad = n => String(n).padStart(2, '0');
    return pad(d.getDate()) + '/' + pad(d.getMonth()+1) + '/' + d.getFullYear() + ' ' + pad(d.getHours()) + ':' + pad(d.getMinutes());
  }

  saveBtn.addEventListener('click', function () {
    errorBox.classList.add('d-none');
    if (!titleEl.value.trim()) { showError("Le titre est requis."); return; }
    if (!fpStart.selectedDates[0]) { showError("La date de début est requise."); return; }

    const id   = eidEl.value;
    const isEdit = !!id;
    const fd   = new FormData();
    fd.append(csrfName, csrfHash);
    if (isEdit) fd.append('id', id);
    fd.append('title',       titleEl.value);
    fd.append('start',       fmtDate(fpStart.selectedDates[0]));
    fd.append('end',         fmtDate(fpEnd.selectedDates[0]));
    fd.append('color',       colorEl.value);
    fd.append('description', descEl.value);

    saveBtn.disabled = true;
    fetch(isEdit ? url.update : url.add, { method: 'POST', body: fd, credentials: 'same-origin' })
      .then(r => r.json().catch(() => ({ error: 1, msg: 'Réponse invalide' })))
      .then(j => {
        if (j && j.error) { showError(j.msg || 'Erreur'); return; }
        modal.hide();
        calendar.refetchEvents();
      })
      .catch(err => showError(err.message || String(err)))
      .finally(() => { saveBtn.disabled = false; });
  });

  deleteBtn.addEventListener('click', function () {
    const id = eidEl.value;
    if (!id) return;
    if (!confirm('<?php echo addslashes(lang('r_u_sure') ?: 'Supprimer cet événement ?'); ?>')) return;
    const fd = new FormData();
    fd.append(csrfName, csrfHash);
    fetch(url.del + '/' + id, { method: 'POST', body: fd, credentials: 'same-origin' })
      .then(r => r.json().catch(() => ({})))
      .then(() => { modal.hide(); calendar.refetchEvents(); })
      .catch(err => showError(err.message || String(err)));
  });

  function quickUpdate(evt) {
    const fd = new FormData();
    fd.append(csrfName, csrfHash);
    fd.append('id',    evt.id);
    fd.append('title', evt.title);
    fd.append('start', fmtDate(evt.start));
    fd.append('end',   fmtDate(evt.end));
    fd.append('color', evt.backgroundColor || '#666cff');
    fd.append('description', (evt.extendedProps && evt.extendedProps.description) || '');
    fetch(url.update, { method: 'POST', body: fd, credentials: 'same-origin' })
      .then(r => r.json().catch(() => ({})))
      .catch(err => console.error(err));
  }

  newBtn.addEventListener('click', function () { openCreateModal(); });

  modalEl.addEventListener('hidden.bs.modal', resetForm);
});
</script>
