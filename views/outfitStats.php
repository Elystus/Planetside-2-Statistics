<div class="row">
    <div class="span4">
        <form class="well" method="POST">
            <div class="control-group">
                <label class="control-label" for="outfit-var">Outfit Tag</label>
                <div class="controls">
                    <input type="text" class="input-block-level" name="outfit-var" id="outfit-var">
                    <p class="help-block">Use your Outfit tag to look up stats about your outfit.</p>
                </div>
                <div class="controls">
                    <input type="hidden" name="outfit-type" value="tag">
                </div>
            </div>
            <div class="form-actions">
                    <button type="submit" class="btn btn-primary input-block-level">Search</button>
            </div>
        </form>
        </div>
            <div class="span4">
        <form class="well" method="POST">
            <div class="control-group">
                <label class="control-label" for="outfit-var">Outfit Name</label>
                <div class="controls">
                    <input type="text" class="input-block-level" name="outfit-var" id="outfit-var">
                    <p class="help-block">Use your Outfit Name to look up stats about your Outfit. </p>
                </div>
                <div class="controls">
                    <input type="hidden" name="outfit-type" value="name">
                </div>
            </div>
            <div class="form-actions">
                    <button type="submit" class="btn btn-primary input-block-level">Search</button>
            </div>
        </form>
        </div>
            <div class="span4">
        <form class="well" method="POST">
            <div class="control-group">
                <label class="control-label" for="outfit-var">Outfit Member</label>
                <div class="controls">
                    <input type="text" class="input-block-level" name="outfit-var" id="outfit-var">
                    <p class="help-block">use a member of your Outfit to look up stats about your outfit.</p>
                </div>
                <div class="controls">
                    <input type="hidden" name="outfit-type" value="member">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary input-block-level">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
