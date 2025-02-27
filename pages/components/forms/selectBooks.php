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

<table class="table">
    <?php foreach($unique_books as $ubooks): ?>
        <thead class="table-group-divider">
            <tr>
                <th colspan="3"><?= $ubooks->genre ?></th>
            </tr>
            <tr>
                <th width="20"><input type="checkbox" class="form-check-input me-3" id="genre-<?=$ubooks->genre_id?>" data-book-id="book-<?=$ubooks->genre_id?>-" name="genres[]" onclick="onGenreCheck(event)"></th>
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
                    <td><input type="checkbox" class="form-check-input me-3" name="books[<?=$book->id?>]" id="book-<?=$ubooks->genre_id?>-<?=$book->id?>"></td>
                    <td><?= $book->name ?></td>
                    <td><?= $book->author ?></td>
                </tr>
            <?php endforeach ?>

        </tbody>
    <?php endforeach; ?>
</table>

<script>
    $(function() {
    });
    function onGenreCheck(e){
        $genre = $("#" + e.target.id);
        $(`[id^=${$genre.attr("data-book-id")}]`)
        .attr("checked", e.target.checked);
    }
</script>

