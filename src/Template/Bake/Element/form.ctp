<%
use Cake\Utility\Inflector;

   $extras = [];
%>
<section class="content-header">
  <h1>
    <?= __('<%= $singularHumanName %>') ?>
    <small><?= __('<%= Inflector::humanize($action) %>') ?></small>
  </h1>
  <ol class="breadcrumb">
    <li>
    <?= $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Back'), ['action' => 'index'], ['escape' => false]) ?>
    </li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?= __('Form') ?></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <?= $this->Form->create($<%= $singularVar %>, array('role' => 'form')) ?>
          <div class="box-body">
          <?php
<%
    foreach ($fields as $field) {
      if (in_array($field, $primaryKey)) {
        continue;
      }
      if (isset($keyFields[$field])) {
        $fieldData = $schema->getColumn($field);
        if (!empty($fieldData['null'])) {
%>
            echo $this->Form->control('<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'empty' => true]);
<%
        } else {
%>
            echo $this->Form->control('<%= $field %>', ['options' => $<%= $keyFields[$field] %>]);
<%
        }
        continue;
      }
      if (!in_array($field, ['created', 'modified', 'updated'])) {
        $fieldData = $schema->getColumn($field);
        if (($fieldData['type'] === 'date')) {
            $extras[] = 'datepicker';
%>
            echo $this->Form->control('<%= $field %>', ['empty' => true, 'default' => '', 'class' => 'datepicker form-control', 'type' => 'text']);
<%
        } else {
%>
            echo $this->Form->control('<%= $field %>');
<%
        }
      }
    }
    if (!empty($associations['BelongsToMany'])) {
      foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
%>
            echo $this->Form->control('<%= $assocData['property'] %>._ids', ['options' => $<%= $assocData['variable'] %>]);
<%
      }
    }
%>
          ?>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <?= $this->Form->button(__('Save')) ?>
          </div>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</section>

<%
    if (!empty($extras)) {
        foreach($extras as $element) {
        %>
        <% echo $this->element($element); %>
        <%
        }
    }
%>
