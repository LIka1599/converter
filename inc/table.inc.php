<h1 class="h2 mb-4">Текущее значение валют в рублях</h1>
<div class="courses">
  <?php
  foreach ($data["Valute"] as $row) {
  ?>
    <div class="course-item card card-body">
      <div class="course-item-title"><?= $row["CharCode"] ?></div>
      <div class="course-item-value" data-value="EUR"><?= round($row["Value"] / $row["Nominal"], 3) ?></div>
    </div>
  <?
  }
  ?>
</div>