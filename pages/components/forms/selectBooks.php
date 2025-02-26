<?php $data = Response::getData(); ?>
<?php
$unique_books = [];
$genre_ids = [];

foreach ($data->books as $book) {
    if (!in_array($book->genre_id, $genre_ids)) {
        $genre_ids[] = $book->genre_id; // Store unique genre_id
        $unique_books[] = $book; // Store the book with that genre_id
    }
}
?>
<!-- <div class="accordion" id="accordionExample">
    <?php foreach($unique_books as $ubooks): ?>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#genre-<?= $ubooks->genre_id ?>" aria-expanded="true" aria-controls="collapseOne">
                    <input type="checkbox" class="form-check-input me-3" name="genres[]"><?= $ubooks->genre ?>
                </button>
            </h2>
            <div id="genre-<?= $ubooks->genre_id ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <?php
                        $books = array_filter($data->books, function ($book) use ($ubooks) {
                            return $book->genre_id == $ubooks->genre_id;
                        });
                    ?>
                    <?php foreach($books as $book) : ?>
                        <div class="mb-2">
                                <input type="checkbox" class="form-check-input me-3" name="books[]" id="book-<?=$book->id?>"> 
                                <label for="book-<?=$book->id?>"><?= $book->name ?></label>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div> -->
<table class="table">
    <?php foreach($unique_books as $ubooks): ?>
        <thead class="table-group-divider">
            <tr>
                <th colspan="3"><?= $ubooks->genre ?></th>
            </tr>
            <tr>
                <th width="20"><input type="checkbox" class="form-check-input me-3" name="genres[]"></th>
                <th>Name</th>
                <th>Author</th>
            </tr>
        </thead>
        <tbody >
            <?php
                $books = array_filter($data->books, function ($book) use ($ubooks) {
                    return $book->genre_id == $ubooks->genre_id;
                });
            ?>
            <?php foreach($books as $book) : ?>
                <tr>
                    <td><input type="checkbox" class="form-check-input me-3" name="books[]" id="book-<?=$book->id?>"></td>
                    <td><?= $book->name ?></td>
                    <td><?= $book->author ?></td>
                </tr>
            <?php endforeach ?>

        </tbody>
    <?php endforeach; ?>
</table>

