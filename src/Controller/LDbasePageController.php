<?php

namespace Drupal\ldbase_content\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\examples\Utility\DescriptionTemplateTrait;
use Drupal\Core\Render\Markup;

/**
 * Controller routines for page example routes.
 */
class LDbasePageController extends ControllerBase {

  public function access_denied() {
    return [
      '#markup' => '<p>' . $this->t('This is the Access Denied (403) page. Users will see it when they try to go to something they don\'t have access to.') . '</p>',
    ];
  }

  public function not_found() {
    return [
      '#markup' => '<p>' . $this->t('This is the Not Found (404) page. Users will see it when they try to go to something that doesn\'t exist.') . '</p>',
    ];
  }

  public function home() {
    return [
      '#markup' => '<p>' . $this->t('This is the front page.') . '</p>',
    ];
  }

  public function contact() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Contact" page.') . '</p>',
    ];
  }

  public function about() {
    return [
      '#markup' => '<p>' . $this->t('This is the "About" page.') . '</p>',
    ];
  }

  public function about_ldbase() {
    $about_ldbase_content = <<<EOM
<div id="about-ldbase-page-wrapper" class="about-ldbase-page">
  <p class="about-ldbase-page">Welcome to LDbase, a NIH-funded collaboration between researchers and librarians to build a first-of-its-kind behavioral data repository containing decades of knowledge from educational and developmental sciences on individuals across the full range of abilities. LDbase will be an open science resource for the educational and developmental science scientific communities, providing a secure place to store and access data and access materials about aspects of data management and analyses. The aim of LDbase is to be a powerful resource that opens up new areas of research and accelerates discoveries, inspiring innovative research that helps us understand how individuals learn, develop, are different from each other, learn new languages, respond to interventions, and interact with their communities.</p>
  <p class="about-ldbase-page">You may cite LDbase in your scholarship as:<br/>
Hart, S.A., Schatschneider, T.R. Reynolds, F.E. Calvo, B. J. Brown, B. Arsenault, M.R.K. Hall, W. van Dijk, A.A. Edwards, J.A. Shero, R. Smart & J.S. Phillips (2020). <em>LDbase.</em> <a href="http://doi.org/10.33009/ldbase">http://doi.org/10.33009/ldbase</a>.</p>
</div>
EOM;
    return [
      '#markup' => $about_ldbase_content,
    ];
  }

  public function why_share_behavioral_data() {
    $why_share_behavioral_data_content = <<<EOM
<div id="why-share-behavioral-data-page-wrapper" class="why-share-behavioral-data-page">
  <script src="https://venngage.net/js/embed/v1/embed.js" data-vg-id="Uz65vsS6hI" data-title="10 BENEFITS OF DATA SHARING" data-w="816" data-h="2250" data-multipage="true"></script>
  <ol id="why-share-behavioral-data-page-list" class="why-share-behavioral-data-page">
    <li>
      <h2>Engage in Open Science</h2>
      <p>Sharing data is one of the most important elements of Open Science.</p>
    </li>
    <li>
      <h2>Stimulate Collaboration</h2>
      <p>Sharing data can lead to more collaborative research efforts by forming alliances.</p>
    </li>
    <li>
      <h2>Citation</h2>
      <p>Publication with open data attached get cited more often than publications without open data.</p>
    </li>
    <li>
      <h2>Save resources</h2>
      <p>Sharing data reduces cost of resources, such as time and money needed to collect similar data.</p>
    </li>
    <li>
      <h2>Support young scholars</h2>
      <p>Provides necessary career opportunities to early career researchers who may not have funds to get pilot data for grants, or to complete large projects. Provides opportunities for students to use high-quality data for course projects.</p>
    </li>
    <li>
      <h2>Support Combining Data</h2>
      <p>Sharing data enables combining data sets through integrative data analysis, which can lead to larger analyzable data sets (including of low-base populations) and meta-analysis.</p>
    </li>
    <li>
      <h2>Support advances in education and developmental science</h2>
      <p>Sharing data can lead to more creativity in research; other researchers may have different questions based on the same data, collectively this can advance developmental and educational research faster and in a more robust way.</p>
    </li>
    <li>
      <h2>Support other researchers</h2>
      <p>Provide necessary career opportunities to researchers who are at smaller IHEs and may not have resources to collect data or finish projects.</p>
    </li>
    <li>
      <h2>Transparency</h2>
      <p>Sharing data demonstrates you care about the integrity of your research, letting others verify the results.</p>
    </li>
    <li>
      <h2>Comply with federal grant requirements</h2>
      <p>Your funder might require you to share your data</p>
    </li>
  </ol>
  <p class="why-share-behavioral-data-page">Edwards, A., van Dijk, W., & Hart, S.A. (2020). 10 benefits of data sharing. Available <a href="https://venngage.net/ps/Uz65vsS6hI/new-10-benefits-of-data-sharing">https://venngage.net/ps/Uz65vsS6hI/new-10-benefits-of-data-sharing</>. Reuse available under a CC BY 4.0 license.</p>
</div>
EOM;
    return [
      '#markup' => $why_share_behavioral_data_content,
      '#allowed_tags' => ['script', 'iframe', 'div', 'ol', 'li', 'h2', 'p', 'a'],
    ];
  }

  public function who_might_want_to_use_ldbase() {
    $who_might_want_to_use_ldbase_content = <<<EOM
<div id="who-might-want-to-use-ldbase-page-wrapper" class="who-might-want-to-use-ldbase-page">
  <p>LDbase is a data repository that can be used by the research community for multiple purposes.</p>
  <ol>
    <li>
      <h2>For Data Storage Needs</h2>
      <ol type="a">
        <li>
          <h3>For Grants</h3>
          <p>Many granting agencies now require investigators of a funded project to deposit their data into a repository by a predetermined time. Investigators may attach lab members/staff to their projects within LDbase and can choose the level of access they wish for every dataset, document or code they store in LDbase. LDbase meets all known federal and community requirements, including meeting the FAIR principles, HIPPA and FERPA privacy laws, and GDRP regulations.</p>
        </li>
        <li>
          <h3>For Journals</h3>
          <p>Some journals require that data used for a publication within their journal be stored openly, for data reuse and checking. LDbase provides an easy way to meet this requirement, with a link and doi available for every component stored in LDbase.</p>
        </li>
        <li>
          <h3>For Good of Community</h3>
          <p>Some members of the community might wish to store their data in LDbase simply to get their data out to their community. LDbase is a free, easy to use place to store data, making it ideal for these members. Backed by FSU Libraries, LDbase is able to give peace of mind to the community that their data will be stored and managed indefinitely.</p>
        </li>
      </ol>
    </li>
    <li>
      <h2>For Data Use Needs</h2>
      <ol type="a">
        <li>
          <h3>Meta Analysis</h3>
          <p>The repository is completely searchable and can be used for meta-analytic purposes.  Oftentimes a meta-analysis is limited by the results that are reported in published and unpublished manuscripts. Having access to the original data will allow for the possible aggregation of results that were not performed by the original authors.</p>
        </li>
        <li>
          <h3>Pilot Data, Novel Research Questions, Exploratory/Confirmatory Dataset</h3>
          <p>Datasets in LDbase can also provide valuable pilot data to support a grant application or to get estimates of effect size for a power analysis. Novel research questions may also be investigated using existing data. This can be especially useful to investigators who do not have the resources to collect similar data. Sometimes an investigator wishes to run exploratory analyses on one dataset, and then use a second for confirmatory analyses. LDbase gives access to a wealth of datasets for such purposes.</p>
        </li>
        <li>
          <h3>Confirm Published Findings</h3>
          <p>Openly available datasets underlying published findings allow the community to check reported results, giving credibility to our science.</p>
        </li>
        <li>
          <h3>For Teachers/Classroom Use</h3>
          <p>Often statistics or research methods teachers would like real datasets for students to use to practice a technique or to serve as an example. Datasets stored in LDbase can be used to support student training.</p>
        </li>
      </ol>
    </li>
  </ol>
</div>

EOM;
    return [
      '#markup' => $who_might_want_to_use_ldbase_content,
    ];
  }

  public function ldbase_team() {
    $ldbase_team_content = <<<EOM
<div id="ldbase-team-page-wrapper" class="ldbase-team-page">

  <div class="ldbase-team-page ldbase-team-page-member-wrapper">
    <h2>Sara A. Hart</h2>
    <span class="ldbase-team-page ldbase-team-page-member-line">Principal Investigator</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Associate Professor of Psychology & Florida Center for Reading Research Florida State University</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line"><a href="mailto:sahart@fsu.edu">sahart@fsu.edu</a></span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line"><a href="https://twitter.com/saraannhart">@saraannhart</a></span><br/>
  </div>

  <div class="ldbase-team-page ldbase-team-page-member-wrapper">
    <h2>Christopher Schatshneider</h2>
    <span class="ldbase-team-page ldbase-team-page-member-line">Principal Investigator</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Professor of Psychology</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Associate Director of the Florida Center for Reading Research</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line"><a href="schatschneider@psy.fsu.edu">schatschneider@psy.fsu.edu</a></span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line"><a href="https://twitter.com/schotz">@schotz</a></span><br/>
  </div>

  <div class="ldbase-team-page ldbase-team-page-member-wrapper">
    <h2>Jean Phillips</h2>
    <span class="ldbase-team-page ldbase-team-page-member-line">Co-Investigator</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Associate Dean of Libraries for Technology and Digital Scholarship, Strozier Library, Florida State University</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line"><a href="jsphillips2@fsu.edu">jsphillips2@fsu.edu</a></span><br/>
  </div>

  <div class="ldbase-team-page ldbase-team-page-member-wrapper">
    <h2>Favenzio Calvo</h2>
    <span class="ldbase-team-page ldbase-team-page-member-line">Director of Software Development</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Florida State University Libraries</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line"><a href="fcalvo@fsu.edu">fcalvo@fsu.edu</a></span><br/>
  </div>

  <div class="ldbase-team-page ldbase-team-page-member-wrapper">
    <h2>Bryan J. Brown</h2>
    <span class="ldbase-team-page ldbase-team-page-member-line">Repository Developer</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Associate Librarian</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Florida State University</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line"><a href="bjbrown@fsu.edu">bjbrown@fsu.edu</a></span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line"><a href="https://twitter.com/bryjbrown">@bryjbrown</a></span><br/>
  </div>

  <div class="ldbase-team-page ldbase-team-page-member-wrapper">
    <h2>Brian Arsenault</h2>
    <span class="ldbase-team-page ldbase-team-page-member-line">Web Developer</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Assistant Librarian</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Florida State University Libraries</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line"><a href="barsenault@fsu.edu">barsenault@fsu.edu</a></span><br/>
  </div>

  <div class="ldbase-team-page ldbase-team-page-member-wrapper">
    <h2>Mason R.K. Hall</h2>
    <span class="ldbase-team-page ldbase-team-page-member-line">Systems Integration Developer and Usability Specialist​​</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Associate Librarian</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Florida State University Libraries</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line"><a href="mrhall@fsu.edu">mrhall@fsu.edu</a></span><br/>
  </div>

  <div class="ldbase-team-page ldbase-team-page-member-wrapper">
    <h2>Tara R. Reynolds</h2>
    <span class="ldbase-team-page ldbase-team-page-member-line">Database Manager</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Associate in Research, Florida Center for Reading Research </span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Florida State University</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line"><a href="trreynolds@fsu.edu">trreynolds@fsu.edu</a></span><br/>
  </div>

  <div class="ldbase-team-page ldbase-team-page-member-wrapper">
    <h2>Wilhelmina van Dijk</h2>
    <span class="ldbase-team-page ldbase-team-page-member-line">Postdoctoral Scholar</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Florida State University</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line"><a href="wvandijk@fsu.edu">wvandijk@fsu.edu</a></span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line"><a href="https://twitter.com/willavandijk">@WillavanDijk</a></span><br/>
  </div>

  <div class="ldbase-team-page ldbase-team-page-member-wrapper">
    <h2>Ashley Edwards</h2>
    <span class="ldbase-team-page ldbase-team-page-member-line">Ph.D. student</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Developmental Psychology</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Florida State University</span><br/>
  </div>

  <div class="ldbase-team-page ldbase-team-page-member-wrapper">
    <h2>Jeffrey Shero</h2>
    <span class="ldbase-team-page ldbase-team-page-member-line">Ph.D. student</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Developmental Psychology</span><br/>
    <span class="ldbase-team-page ldbase-team-page-member-line">Florida State University</span><br/>
  </div>
</div>
EOM;
    return [
      '#markup' => $ldbase_team_content,
    ];
  }

  public function resources() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Resources" page.') . '</p>',
    ];
  }

  public function general_user_agreement() {
    $general_user_agreement_content = <<<EOM
<p>Coming soon!</p>
EOM;
    return [
      '#markup' => $general_user_agreement_content,
    ];
  }

  public function user_guide() {
    $user_guide_content = <<<EOM
<p>Coming soon!</p>
EOM;
    return [
      '#markup' => $user_guide_content,
    ];
  }

  public function faq() {
    $faq_content = <<<EOM
<p>Coming soon!</p>
EOM;
    return [
      '#markup' => $faq_content,
    ];
  }


  public function best_practices() {
    $best_practices_content = <<<EOM
<div id="best-practices-page-wrapper" class="best-practices-page">
  <ol>
    <li>
      <h2>Working with your IRB</h2>
      <p>Do you want to know more about IRB considerations for data sharing? See this white paper on thinking about informed consent language and data use agreements.</p>
      <iframe src="https://widgets.figshare.com/articles/13215305/embed?show_title=1" width="568" height="351" allowfullscreen frameborder="0"></iframe>
      <p>Paper by Shero & Hart, 2020, available at <a href="https://figshare.com/articles/preprint/Working_with_your_IRB_Obtaining_consent_for_open_data_sharing_through_consent_forms_and_data_use_agreements/13215305">https://figshare.com/articles/preprint/Working_with_your_IRB_Obtaining_consent_for_open_data_sharing_through_consent_forms_and_data_use_agreements/13215305</a> under a CC By 4.0 license.</p>
    </li>
    <li>
      <h2>General data management guidelines</h2>
      <p>Data sharing starts with good data management. See this document for some general best tips for good data management practices.</p>
      <iframe src="https://widgets.figshare.com/articles/13215350/embed?show_title=1" width="568" height="351" allowfullscreen frameborder="0"></iframe>
      <p>Paper by Reynolds & Schatschneider, 2020, available at <a href="https://figshare.com/articles/preprint/The_Basics_of_Data_Management/13215350">https://figshare.com/articles/preprint/The_Basics_of_Data_Management/13215350</a> under a CC By 4.0 license.</p>
    </li>
    <li>
      <h2>Data De-Identification</h2>
	    <p>Are you ready to make sure your data are deidentified? First, work through these steps:</p>
	    <script src="https://venngage.net/js/embed/v1/embed.js" data-vg-id="5p6yjaAGTSs" data-title="5 Things to check for data deidentification" data-w="816" data-h="2200" data-multipage="true"></script>
	    <p>Now, do your final checks:</p>
      <iframe src="https://widgets.figshare.com/articles/13228664/embed?show_title=1" width="568" height="351" allowfullscreen frameborder="0"></iframe>
      <p>Edwards, A. & Schatschneider, C. (2020). 5 things to check for data de-identification. Available at <a href="https://venngage.net/ps/5p6yjaAGTSs/new-5-things-to-check-for-data-deidentification">https://venngage.net/ps/5p6yjaAGTSs/new-5-things-to-check-for-data-deidentification</a>. Reuse available under a CC BY 4.0 license.</p>
      <p>Paper by Edwards & Schatschneider, 2020, available at <a href="https://figshare.com/articles/preprint/De-Identification_Guide/13228664">https://figshare.com/articles/preprint/De-Identification_Guide/13228664</a> under a CC By 4.0 license.</p>
    </li>
    <li>
      <h2>License types</h2>
      <p>Licenses allow you to choose how your data and documents can be reused.</p>
      <p>For data we recommend Open Data Commons Attribution License (ODC-by) which allows others to use, modify, and share your data but must cite your data when doing so (i.e., if someone uses your data for an analysis in a publication, they must cite your data).</p>
      <p>For accompanying documentation, we recommend you examine the <a href="https://creativecommons.org/licenses/">Creative Commons Licences</a> to choose which is most appropriate for you. For a great summary of what they all mean, check out <a href="https://creativecommons.org/licenses/">https://foter.com/blog/how-to-attribute-creative-commons-photos/</a>.</p>
    </li>
    <li>
      <h2>Citing LDbase products</h2>
      <p>Each product on LDbase includes a suggested citation, please use that when citing to give credit to the original authors who shared their product with you!</p>
      <p>As LDbase was created through NIH funding, we would very much appreciate you citing LDbase in your work. To do so, you may use:</p>
      <p>Hart, S.A., Schatschneider, T.R. Reynolds, F.E. Calvo, B. J. Brown, B. Arsenault, M.R.K. Hall, W. van Dijk, A.A. Edwards, J.A. Shero, R. Smart & J.S. Phillips (2020). <em>LDbase</em>. <a href="http://doi.org/10.33009/ldbase">http://doi.org/10.33009/ldbase</a>.</p>
    </li>
    <li>
      <h2>Combining data</h2>
      <p>For some research questions, it is better to have large sample sizes. Instead of going out to collect these samples, researchers can combine data from existing studies. There are two main ways to combine existing data: through meta-analysis of summary statistics, and through Integrative Data Analysis using individual participant data. See this white paper for more information and suggested readings for both.</p>
	    <iframe src="https://widgets.figshare.com/articles/13215356/embed?show_title=1" width="568" height="351" allowfullscreen frameborder="0"></iframe>
      <p>Paper by van Dijk & Schatschneider, 2020, available at <a href="https://figshare.com/articles/preprint/Combining_Data/13215356">https://figshare.com/articles/preprint/Combining_Data/13215356</a> under a CC By 4.0 license.</p>
    </li>
    <li>
      <h2>Open Science</h2>
      <p>Are you interested to know more about open science practices? Here is a brief review to get you started.</p>
	    <iframe src="https://widgets.figshare.com/articles/13215392/embed?show_title=1" width="568" height="351" allowfullscreen frameborder="0"></iframe>
      <p>Paper by van Dijk & Hart, 2020, available at <a href="https://figshare.com/articles/preprint/Open_Science/13215392">https://figshare.com/articles/preprint/Open_Science/13215392</a> under a CC By 4.0 license.</p>
    </li>
  </ol>
</div>
EOM;
    return [
      '#markup' => $best_practices_content,
      '#allowed_tags' => ['script', 'iframe', 'div', 'ol', 'li', 'h2', 'p', 'a'],
    ];
  }

  public function templates() {
    $templates_content = <<<EOM
<div id="templates-page-wrapper" class="templates-page">
  <ol>
    <li>
      <h2>IRB Application</h2>
      <p>A template of a typical US IRB protocol which including data sharing.</p>
      <iframe src="https://widgets.figshare.com/articles/13218797/embed?show_title=1" width="568" height="351" allowfullscreen frameborder="0"></iframe>
      <p>Paper by Shero & Hart, 2020, available at <a href="https://figshare.com/articles/preprint/IRB_Protocol_Template/13218797">https://figshare.com/articles/preprint/IRB_Protocol_Template/13218797</a> under a CC By 4.0 license.</p>
    </li>
    <li>
      <h2>Informed consent language</h2>
	    <p>A template of a typical informed consent with the anticipation of data sharing.</p>
	    <iframe src="https://widgets.figshare.com/articles/13218773/embed?show_title=1" width="568" height="351" allowfullscreen frameborder="0"></iframe>
      <p>Paper by Shero & Hart, 2020, available at <a href="https://figshare.com/articles/preprint/Informed_Consent_Template/13218773">https://figshare.com/articles/preprint/Informed_Consent_Template/13218773</a> under a CC By 4.0 license.</p>
    </li>
    <li>
      <h2>Data use agreement</h2>
	    <p>Coming soon!</p>
    </li>
    <li>
      <h2>Data management plan</h2>
	    <p>An example of a data management plan.</p>
	    <iframe src="https://widgets.figshare.com/articles/13218743/embed?show_title=1" width="568" height="351" allowfullscreen frameborder="0"></iframe>
      <p>Paper by Hart, 2020, available at <a href="https://figshare.com/articles/preprint/Example_of_a_Data_Management_Plan/13218743">https://figshare.com/articles/preprint/Example_of_a_Data_Management_Plan/13218743</a> under a CC By 4.0 license.</p>
    </li>
    <li>
      <h2>Preregistrations using secondary data analysis</h2>
      <p>The Center for Open Science has brought together a team to create a useful template for secondary data analysis preregistrations. Check it out here <a href="https://osf.io/x4gzt/">https://osf.io/x4gzt/</a> and cite:</p>
      <p>Weston, S. J., Mellor, D. T., Bakker, M., Van den Akker, O., Campbell, L., Ritchie, S. J., … DeHaven, A. C. (2020, September 22). Secondary Data Preregistration. Retrieved from <a href="https://osf.io/x4gzt/">osf.io/x4gzt</a></p> 
    </li>
  </ol>
</div>
EOM;
    return [
      '#markup' => $templates_content,
      '#allowed_tags' => ['script', 'iframe', 'div', 'ol', 'li', 'h2', 'p', 'a'],
    ];
  }

  public function community() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Community" page.') . '</p>',
    ];
  }

  public function users() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Users" page.') . '</p>',
    ];
  }

  public function institutions() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Institutions" page.') . '</p>',
    ];
  }

}
