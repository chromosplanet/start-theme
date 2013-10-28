<?php

	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Por favor, não carregue a página diretamente. Muito obrigado!');

	if ( post_password_required() ) { ?>
		<?php echo 'Este post é protegido por senha. Digite a senha para ver os comentários.'; ?>
	<?php
		return;
	}
?>

<?php if ( have_comments() ) : ?>
	
	<h2 id="comments"><?php comments_number('Nenhum comentário', 'Um comentário', '% Comentários');?></h2>

	<div class="navigation">
		<div class="next-posts"><?php previous_comments_link() ?></div>
		<div class="prev-posts"><?php next_comments_link() ?></div>
	</div>

	<ol class="commentlist">
		<?php wp_list_comments(); ?>
	</ol>

	<div class="navigation">
		<div class="next-posts"><?php previous_comments_link() ?></div>
		<div class="prev-posts"><?php next_comments_link() ?></div>
	</div>
	
 <?php else : // exibido se não há nenhum comentário até agora ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comentários fechados ?>
		<p>Os comentários estão fechados.</p>

	<?php endif; ?>
	
<?php endif; ?>

<?php if ( comments_open() ) : ?>

<div class="respond">

	<div class="cancel-comment-reply">
		<?php cancel_comment_reply_link(); ?>
	</div>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<p>Você precisa estar <a href="<?php echo wp_login_url( get_permalink() ); ?>">logado</a> para postar um comentário.</p>
	<?php else : ?>

	<?php comment_form(); ?>

	<?php endif; ?>
	
</div>

<?php endif; ?>