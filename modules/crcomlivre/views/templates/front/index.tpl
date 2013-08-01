{if isset($message)}<p class="confirmation">{$message}</p>{/if}
<h2>{l s='Share your opinion on our site !' mod='crcomlivre'}</h2>
<p>{l s='In this space, you can leave your testimonials and reviews on our site and products. This guestbook is for you!' mod='crcomlivre'}</p>

{if $logged}
    <div id="crcomlivre">
        <h2>{l s='Add a new comment' mod='crcomlivre'}</h2>
        <form action="{$request_uri}" name="my_form" method="post">
            <input type="hidden" name="client" value="{$cookie->id_customer}" />
            <table>
                <tr>
                    <td style="text-align:right">{l s='Message title' mod='crcomlivre'}</td>
                    <td><input type="text" name="titre" /></td>
                </tr>
                 <tr>
                    <td style="text-align:right">{l s='Note' mod='crcomlivre'}</td>
                    <td><input type="text" name="note" style="width:50px;" /> /10</td>
                </tr>
                <tr>
                    <td style="text-align:right">{l s='Your message' mod='crcomlivre'}</td>
                    <td><textarea name="message" rows="3" cols="30"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="bouton" value="{l s='Send' mod='crcomlivre'}" class="button" /></td>
                </tr>
            </table>    
        </form>
   	</div>
{else}
	{if $invite==0}
    <p class="error">{l s='You must be logged in to leave a message' mod='crcomlivre'}</p>
    {else}
        <div id="crcomlivre">
            <h2>{l s='Add a new comment' mod='crcomlivre'}</h2>
            <form action="{$request_uri}" name="my_form" method="post">
                <input type="hidden" name="client" value="0" />
                <table>
                    <tr>
                        <td style="text-align:right">{l s='Message title' mod='crcomlivre'}</td>
                        <td><input type="text" name="titre" /></td>
                    </tr>
                    <tr>
                    	<td style="text-align:right">{l s='Note' mod='crcomlivre'}</td>
                    	<td><input type="text" name="note" style="width:50px;" /> /10</td>
               		</tr>
                    <tr>
                        <td style="text-align:right">{l s='Your message' mod='crcomlivre'}</td>
                        <td><textarea name="message" rows="3" cols="30"></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" name="bouton" value="{l s='Send' mod='crcomlivre'}" class="button" /></td>
                    </tr>
                </table>    
            </form>
      	</div>
    {/if}
    
{/if}

<div id="crcomlivre" style="margin-top:25px;">
    <h2>{l s='Latest testimonials and Opinions' mod='crcomlivre'}</h2>
    
    {if isset($livres) and !empty($livres)}
        <form action="{$request_uri}" method="post" name="my_form_2">
            {if $page!=1}<input style="margin:0" type="image" name="page_precedent" src="{$base_dir}modules/crcomlivre/img/previous.gif" />{/if}&nbsp;{l s='Page number' mod='crcomlivre'} {$page} {l s='of' mod='crcomlivre'} {$nbre_pages|ceil}&nbsp;
            {if $page<$nbre_pages}<input style="margin:0" type="image" name="page_suivant" src="{$base_dir}modules/crcomlivre/img/next.gif" />{/if}
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{l s='Number of results per page' mod='crcomlivre'}
            <select name="par_page" onChange='this.form.submit()'>
                <option value="10" {if isset($par_page) and $par_page==10}selected="selected"{/if}>10</option>
                <option value="20" {if isset($par_page) and $par_page==20}selected="selected"{/if}>20</option>
                <option value="50" {if isset($par_page) and $par_page==50}selected="selected"{/if}>50</option>
            </select>	
        </form>
        {foreach from=$livres item=livre}
            <div class="message">
            {l s='Date:' mod='crcomlivre'} {$livre.date}<br  />
            {foreach from=$clients item=client}
                {if $livre.id_customer==$client.id_customer and $client.id_customer!=0}
                    {l s='Rating given by' mod='crcomlivre'} <strong style="text-transform:capitalize">{$client.firstname} {$client.lastname}</strong>
                {/if}
            {/foreach}
            {if $livre.id_customer==0}
                    {l s='Comment left by a guest' mod='crcomlivre'}
                {/if}
                <br />
             <h4>{$livre.titre}</h4>
             <p>Note: {$livre.note}/10</p>
                <div class="message_2">{$livre.message}</div>
             </div>
        {/foreach}
    {else}
        <p>{l s='There are no reviews yet' mod='crcomlivre'}</p>
    {/if}
</div>