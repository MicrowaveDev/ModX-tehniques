[[!getResources? &parents=`-1` &tpl=`FooterProjectsItem` &resources=`[[#8.tv.multi-projects]]` &sortby=`{"menuindex":"ASC"}`
                          &includeTVs=`1` &processTVs=`1` &limit=`3`]]

[[!getResources? &parents=`[[+id]]` &depth=`0` &tpl=`GeneralListItem` &sortby=`{"menuindex":"ASC"}`
              &includeTVs=`1` &processTVs=`1` &limit=`0` &totalVar=`count` &toPlaceholder=`results`]]
[[+count:isnt=`0`:then=`[[+results]]`]]

[[!getImageList? &tvname=`migx-faq` &docid=`57` &tpl=`FooterFAQ` &where=`{"active:=":"1","MIGX_id:=":"[[#8.tv.single-faq]]"}`]]

<ul>
	  [[!getImageList?
	  &tvname=`myMIGXtv`
	  &tpl=`@CODE:
	      <li>[[+idx]]<img src="[[+image]]"/><p>[[+title]]</p></li>
	  `]]
</ul>

[[+content_type:isnt=`1`:then=`<h4 class="download">`:else=`<h4 class="content-header">`]]

[[!%sitename.example? &namespace=`sitename` &language=`ru`]]

[[!FormIt?
    &hooks=`email`
    &emailTpl=`contactEmailTpl`
    &emailSubject=`Сообщение с контактной формы сайта sitename`
    &emailTo=`[[#378.tv.email-responder?]]`
    &submitVar=`contactForm`
]]
<form method="post" action="[[~[[*id]]]]">
	<input type="text" name="fullname" required placeholder="[[!%sitename.fullname? &namespace=`sitename` &language=`ru`]]" class="req">
	<input type="text" name="email" required placeholder="[[!%sitename.email? &namespace=`sitename` &language=`ru`]]" class="req">
	<input class="btn" type="submit" value="[[!%sitename.submit? &namespace=`sitename` &language=`ru`]]" name="contactForm">
</form>

<base href="[[++site_url]]" />
<title>[[*seo-title:isempty=`[[++site_name]] - [[*pagetitle]]`]]</title>
<meta name="description" content="[[*meta-description:isempty=`[[*description]]`]]" />
<meta name="keywords" content="[[*meta-keywords?]]" />
