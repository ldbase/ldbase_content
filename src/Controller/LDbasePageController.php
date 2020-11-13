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
      '#allowed_tags' => ['script', 'div', 'ol', 'li', 'h2', 'p'],
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

  public function contact() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Contact" page.') . '</p>',
    ];
  }

  public function resources() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Resources" page.') . '</p>',
    ];
  }

  public function general_user_agreement() {
    return [
      '#markup' => '<p>' . $this->t('This is the "General User Agreement" page.') . '</p>',
    ];
  }

  public function user_guide() {
    return [
      '#markup' => '<p>' . $this->t('This is the "User Guide" page.') . '</p>',
    ];
  }

  public function faq() {
    return [
      '#markup' => '<p>' . $this->t('This is the "FAQ" page.') . '</p>',
    ];
  }

  public function best_practices() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Best Practices" page.') . '</p>',
    ];
  }

  public function templates() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Templates" page.') . '</p>',
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
