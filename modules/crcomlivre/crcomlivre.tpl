<div class="block">
	<h4>{l s="View All"}Derniers commentaires</h4>
   	<div class="block_content">
        {if isset($commentaires) and !empty($commentaires)}
            {foreach from=$commentaires item=commentaire}
                <h5><a href="{$base_url}modules/crcomlivre/temoignages.php">{$commentaire.titre}</a></h5>
                    <p>{$commentaire.message|truncate:30:'...':true}</p>
            {/foreach}
        {else}
            <p>{l s='No comments yet' mod='crcomlivre'}</p>
        {/if}
   	</div>
</div>
           