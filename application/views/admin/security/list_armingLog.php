<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-10 text-left">
                <h3 class="panel-title"><?php echo lang('security title arming_list_summary'); ?></h3>
            </div>
        </div>  
    </div>

    <table class="table table-striped table-hover-warning">
        <thead>

            <?php // sortable headers ?>
            <tr>
                <td>
                    <a href="<?php echo current_url(); ?>?sort=id&dir=<?php echo (($dir == 'asc' ) ? 'desc' : 'asc'); ?>&limit=<?php echo $limit; ?>&offset=<?php echo $offset; ?><?php echo $filter; ?>"><?php echo lang('security col security_id'); ?></a>
                    <?php if ($sort == 'ID') : ?><span class="glyphicon glyphicon-arrow-<?php echo (($dir == 'asc') ? 'up' : 'down'); ?>"></span><?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo current_url(); ?>?sort=port&dir=<?php echo (($dir == 'asc' ) ? 'desc' : 'asc'); ?>&limit=<?php echo $limit; ?>&offset=<?php echo $offset; ?><?php echo $filter; ?>"><?php echo lang('security col zone'); ?></a>
                    <?php if ($sort == 'Zone') : ?><span class="glyphicon glyphicon-arrow-<?php echo (($dir == 'asc') ? 'up' : 'down'); ?>"></span><?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo current_url(); ?>?sort=status&dir=<?php echo (($dir == 'asc' ) ? 'desc' : 'asc'); ?>&limit=<?php echo $limit; ?>&offset=<?php echo $offset; ?><?php echo $filter; ?>"><?php echo lang('security col status'); ?></a>
                    <?php if ($sort == 'Status') : ?><span class="glyphicon glyphicon-arrow-<?php echo (($dir == 'asc') ? 'up' : 'down'); ?>"></span><?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo current_url(); ?>?sort=Date&dir=<?php echo (($dir == 'asc' ) ? 'desc' : 'asc'); ?>&limit=<?php echo $limit; ?>&offset=<?php echo $offset; ?><?php echo $filter; ?>"><?php echo lang('security col logged_time'); ?></a>
                    <?php if ($sort == 'Date') : ?><span class="glyphicon glyphicon-arrow-<?php echo (($dir == 'asc') ? 'up' : 'down'); ?>"></span><?php endif; ?>
                </td>
            </tr>

            <?php // search filters ?>
            <tr>
                <?php echo form_open("{$this_url}/armingLog?sort={$sort}&dir={$dir}&limit={$limit}&offset=0{$filter}", array('role'=>'form', 'id'=>"filters")); ?>
                    <th>
                    </th>
                    <th<?php echo ((isset($filters['db2.Name'])) ? ' class="has-success"' : ''); ?>>
                        <?php echo form_input(array('name'=>'port', 'id'=>'port', 'class'=>'form-control input-sm', 'placeholder'=>lang('security input zone'), 'value'=>set_value('db2.Name', ((isset($filters['db2.Name'])) ? $filters['db2.Name'] : '')))); ?>
                    </th>
                    <th<?php echo ((isset($filters['db3.Status'])) ? ' class="has-success"' : ''); ?>>
                        <?php echo form_input(array('name'=>'status', 'id'=>'status', 'class'=>'form-control input-sm', 'placeholder'=>lang('security input status'), 'value'=>set_value('db3.Status', ((isset($filters['db3.Status'])) ? $filters['db3.Status'] : '')))); ?>
                    </th>
                    <th<?php echo ((isset($filters['db3.Date'])) ? ' class="has-success"' : ''); ?>>
                        <?php echo form_input(array('name'=>'date', 'id'=>'date', 'class'=>'form-control input-sm', 'placeholder'=>lang('security input logged_time'), 'value'=>set_value('db3.Date', ((isset($filters['db3.Date'])) ? $filters['db3.Date'] : '')))); ?>
                    </th>
                    <th>
                        <div class="text-right">
                            <a href="<?php echo $this_url; ?>/armingLog" class="btn btn-danger btn-sm tooltips" data-toggle="tooltip" title="<?php echo lang('admin tooltip filter_reset'); ?>"><span class="glyphicon glyphicon-refresh"></span> <?php echo lang('core button reset'); ?></a>
                            <button type="submit" name="submit" value="<?php echo lang('core button filter'); ?>" class="btn btn-success btn-sm tooltips" data-toggle="tooltip" title="<?php echo lang('admin tooltip filter'); ?>"><span class="glyphicon glyphicon-filter"></span> <?php echo lang('core button filter'); ?></button>
                        </div>
                    </th>
                <?php echo form_close(); ?>
            </tr>

        </thead>
        <tbody>

            <?php // data rows ?>
            <?php if ($total) : ?>
                <?php foreach ($securitys as $security) : ?>
                    <tr>
                        <td<?php echo (($sort == 'ID') ? ' class="sorted"' : ''); ?>>
                            <?php echo $security['ID']; ?>
                        </td>
                        <td<?php echo (($sort == 'zone') ? ' class="sorted"' : ''); ?>>
                            <?php echo $security['Port']; ?> - <?php echo $security['Name']; ?>
                        </td>
                        <td<?php echo (($sort == 'name') ? ' class="sorted"' : ''); ?>>
                            <?php echo ($security['Status']) ? '<span class="active">' . lang('admin input active') . '</span>' : '<span class="inactive">' . lang('admin input inactive') . '</span>'; ?>
                            <?php echo $security['Status']; ?>
                        </td>
                        <td<?php echo (($sort == 'status') ? ' class="sorted"' : ''); ?> colspan="2">
                            <?php echo $security['Date']; ?>
                        </td>
                        <!-- <td<?php echo (($sort == 'Status') ? ' class="sorted"' : ''); ?>>
                            <
                            <?php echo ($security['Status']) ? '<span class="active">' . lang('admin input active') . '</span>' : '<span class="inactive">' . lang('admin input inactive') . '</span>'; ?>
                            <?php echo ($security['Status']) ? '<span class="active">' . lang('admin input active') . '</span>' : '<span class="inactive">' . lang('admin input inactive') . '</span>'; ?>
                        </td> -->
                        <!-- <td<?php echo (($sort == 'is_admin') ? ' class="sorted"' : ''); ?>>
                            <?php echo ($security['is_admin']) ? lang('core text yes') : lang('core text no'); ?>
                        </td> -->
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7">
                        <?php echo lang('core error no_results'); ?>
                    </td>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>

    <?php // list tools ?>
    <div class="panel-footer">
        <div class="row">
            <div class="col-md-2 text-left">
                <label><?php echo sprintf(lang('admin label rows'), $total); ?></label>
            </div>
            <div class="col-md-2 text-left">
                <?php if ($total > 10) : ?>
                    <select id="limit" class="form-control">
                        <option value="10"<?php echo ($limit == 10 OR ($limit != 10 && $limit != 25 && $limit != 50 && $limit != 75 && $limit != 100)) ? ' selected' : ''; ?>>10 <?php echo lang('admin input items_per_page'); ?></option>
                        <option value="25"<?php echo ($limit == 25) ? ' selected' : ''; ?>>25 <?php echo lang('admin input items_per_page'); ?></option>
                        <option value="50"<?php echo ($limit == 50) ? ' selected' : ''; ?>>50 <?php echo lang('admin input items_per_page'); ?></option>
                        <option value="75"<?php echo ($limit == 75) ? ' selected' : ''; ?>>75 <?php echo lang('admin input items_per_page'); ?></option>
                        <option value="100"<?php echo ($limit == 100) ? ' selected' : ''; ?>>100 <?php echo lang('admin input items_per_page'); ?></option>
                    </select>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <?php echo $pagination; ?>
            </div>
            <div class="col-md-2 text-right">
                <?php if ($total) : ?>
                    <a href="<?php echo $this_url; ?>/armingLog/export?sort=<?php echo $sort; ?>&dir=<?php echo $dir; ?><?php echo $filter; ?>" class="btn btn-success btn-sm tooltips" data-toggle="tooltip" title="<?php echo lang('admin tooltip csv_export'); ?>"><span class="glyphicon glyphicon-export"></span> <?php echo lang('admin button csv_export'); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

