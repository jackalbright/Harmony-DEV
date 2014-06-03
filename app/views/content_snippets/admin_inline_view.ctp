<?= !empty($snippet['ContentSnippet']['snippet_title']) ? ("<h3>".$snippet['ContentSnippet']['snippet_title']."</h3>") : null; ?>
<?= !empty($snippet['ContentSnippet']['content']) ? ($snippet['ContentSnippet']['content']) : null; # Should allow for RTE, for links ,etc. ?>
