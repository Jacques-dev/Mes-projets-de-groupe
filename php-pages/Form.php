<div class="row">

  <div class="col-lg-6">
    <div class="form-event-group">
      <label for="name-event">Titre</label>
      <input type="text" id="name-event" name="name-event" class="form-event-control" value="<?= isset($data['name-event']) ? $data['name-event'] : ''; ?>" required>
      <?php if (isset($errors["name-event"])): ?>
        <small class="form-text text-muted"><?= $errors['name-event']; ?></small>
      <?php endif; ?>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-event-group">
      <label for="date-event">Date</label>
      <input type="date" id="date-event" name="date-event" class="form-event-control" value="<?= isset($data['date-event']) ? $data['date-event'] : ''; ?>" required>
      <?php if (isset($errors["date-event"])): ?>
        <small class="form-text text-muted"><?= $errors['date-event']; ?></small>
      <?php endif; ?>
    </div>
  </div>

</div>
<div class="row">

  <div class="col-lg-6">
    <div class="form-event-group">
      <label for="start-event">Début</label>
      <input type="time" id="start-event" name="start-event" class="form-event-control" placeholder="HH:MM" value="<?= isset($data['start-event']) ? $data['start-event'] : ''; ?>" required>
      <?php if (isset($errors["start-event"])): ?>
        <small class="form-text text-muted"><?= $errors['start-event']; ?></small>
      <?php endif; ?>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-event-group">
      <label for="end-event">Fin</label>
      <input type="time" id="end-event" name="end-event" class="form-event-control" placeholder="HH:MM" value="<?= isset($data['end-event']) ? $data['end-event'] : ''; ?>" required>
      <?php if (isset($errors["end-event"])): ?>
        <small class="form-text text-muted"><?= $errors['end-event']; ?></small>
      <?php endif; ?>
    </div>
  </div>

</div>

<div class="row">

  <div class="col-lg-2">
    <div class="form-event-group">
      <label for="loopCheck-event">Récurrence</label>
      <?php if($data['loop-event'] != "" || $data['loop-event'] != null) { ?>
        <input type="checkbox" id="loopCheck-event" name="loopCheck-event" class="form-event-control" onclick="eventCheckbox()" checked>
      <?php } else { ?>
        <input type="checkbox" id="loopCheck-event" name="loopCheck-event" class="form-event-control" onclick="eventCheckbox()">
      <?php } ?>
    </div>
  </div>

  <div id="jours-event-loop" class="col-lg-8">
    <div class="row">

      <div class="col-lg-6">
        <div class="form-event-group">
          <label for="loop-event">Tous les :
            <select name="loop-event" id="loop-event" class="form-event-control">
              <option selected value="<?= isset($data['loop-event']) ? $data['loop-event'] : ''; ?>"><?= isset($data['loop-event']) ? $data['loop-event'] : ''; ?></option>
              <option value=""></option>
              <option value="Lundi">Lundi</option>
              <option value="Mardi">Mardi</option>
              <option value="Mercredi">Mercredi</option>
              <option value="Jeudi">Jeudi</option>
              <option value="Vendredi">Vendredi</option>
              <option value="Samedi">Samedi</option>
              <option value="Dimanche">Dimanche</option>
            </select>
          </label>
          <?php if (isset($errors["loop-event"])): ?>
            <small class="form-text text-muted"><?= $errors['loop-event']; ?></small>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-event-group">
          <label for="endLoop-event">Date de fin</label>
          <input type="date" id="endLoop-event" name="endLoop-event" class="form-event-control" value="<?= isset($data['endLoop-event']) ? $data['endLoop-event'] : ''; ?>">
          <?php if (isset($errors["endLoop-event"])): ?>
            <small class="form-text text-muted"><?= $errors['endLoop-event']; ?></small>
          <?php endif; ?>
        </div>
      </div>

    </div>

  </div>

</div>

<div class="form-event-group">
  <label for="description-event">Description</label>
  <textarea type="text" id="description-event" name="description-event" class="form-event-control">
    <?= isset($data['description-event']) ? $data['description-event'] : ''; ?>
  </textarea>
</div>
