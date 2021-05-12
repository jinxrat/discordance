<div class="container" id="discordance">
    <h1 class="mt-4 mb-4 display-6">
        <?php echo get_admin_page_title() ?>
    </h1>
    <form class="border-top py-4" id="discordanceForm" method="POST">
        <div class="nav nav-tabs" id="tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link active" id="webhooks-tab" data-bs-toggle="tab" data-bs-target="#tab-webhooks"
                type="button" role="tab" aria-controls="tab-webhooks" aria-selected="true">Webhooks</button>
            <button class="nav-link" id="embed-tab" data-bs-toggle="tab" data-bs-target="#tab-embed"
                type="button" role="tab" aria-controls="tab-embed" aria-selected="false">Embed format</button>
            <button class="nav-link" id="types-tab" data-bs-toggle="tab" data-bs-target="#tab-types"
                type="button" role="tab" aria-controls="tab-types" aria-selected="false">Post types/Categories</button>
        </div>
        <div class="tab-content p-3 border border-top-0 position-relative" id="tabContent">
            <div class="tab-pane container fade show active" id="tab-webhooks" role="tabpanel" aria-labelledby="webhooks-tab">
                <?php include_once('webhooks.php');?>
            </div>
            <div class="tab-pane container fade" id="tab-embed" role="tabpanel" aria-labelledby="embed-tab">
                <?php include_once('embed.php');?>
            </div>
            <div class="tab-pane container fade" id="tab-types" role="tabpanel" aria-labelledby="types-tab">
                <?php include_once('types.php');?>
            </div>
        </div>
        <div class="submit d-flex align-items-center justify-content-between">
            <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Update settings">
            <div class="d-flex align-items-center">
                <a href="https://github.com/jinxrat/discordance" target="_blank" style="height: 36px; margin-right: 10px;">
                <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjxzdmcKICAgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIgogICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIgogICB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiCiAgIHhtbG5zOnN2Zz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIKICAgeG1sbnM6c29kaXBvZGk9Imh0dHA6Ly9zb2RpcG9kaS5zb3VyY2Vmb3JnZS5uZXQvRFREL3NvZGlwb2RpLTAuZHRkIgogICB4bWxuczppbmtzY2FwZT0iaHR0cDovL3d3dy5pbmtzY2FwZS5vcmcvbmFtZXNwYWNlcy9pbmtzY2FwZSIKICAgdmlld0JveD0iMCAwIDUwMCA1MDAiCiAgIHZlcnNpb249IjEuMSIKICAgaWQ9InN2ZzM0IgogICBzb2RpcG9kaTpkb2NuYW1lPSJkaXNjb3JkYW5jZS5zdmciCiAgIGlua3NjYXBlOnZlcnNpb249IjEuMC4yLTIgKGU4NmM4NzA4NzksIDIwMjEtMDEtMTUpIj4KICA8bWV0YWRhdGEKICAgICBpZD0ibWV0YWRhdGE0MCI+CiAgICA8cmRmOlJERj4KICAgICAgPGNjOldvcmsKICAgICAgICAgcmRmOmFib3V0PSIiPgogICAgICAgIDxkYzpmb3JtYXQ+aW1hZ2Uvc3ZnK3htbDwvZGM6Zm9ybWF0PgogICAgICAgIDxkYzp0eXBlCiAgICAgICAgICAgcmRmOnJlc291cmNlPSJodHRwOi8vcHVybC5vcmcvZGMvZGNtaXR5cGUvU3RpbGxJbWFnZSIgLz4KICAgICAgPC9jYzpXb3JrPgogICAgPC9yZGY6UkRGPgogIDwvbWV0YWRhdGE+CiAgPGRlZnMKICAgICBpZD0iZGVmczM4IiAvPgogIDxzb2RpcG9kaTpuYW1lZHZpZXcKICAgICBwYWdlY29sb3I9IiNmZmZmZmYiCiAgICAgYm9yZGVyY29sb3I9IiM2NjY2NjYiCiAgICAgYm9yZGVyb3BhY2l0eT0iMSIKICAgICBvYmplY3R0b2xlcmFuY2U9IjEwIgogICAgIGdyaWR0b2xlcmFuY2U9IjEwIgogICAgIGd1aWRldG9sZXJhbmNlPSIxMCIKICAgICBpbmtzY2FwZTpwYWdlb3BhY2l0eT0iMCIKICAgICBpbmtzY2FwZTpwYWdlc2hhZG93PSIyIgogICAgIGlua3NjYXBlOndpbmRvdy13aWR0aD0iMTkyMCIKICAgICBpbmtzY2FwZTp3aW5kb3ctaGVpZ2h0PSIxMDE3IgogICAgIGlkPSJuYW1lZHZpZXczNiIKICAgICBzaG93Z3JpZD0iZmFsc2UiCiAgICAgaW5rc2NhcGU6em9vbT0iMS43IgogICAgIGlua3NjYXBlOmN4PSIyNTAiCiAgICAgaW5rc2NhcGU6Y3k9IjE0OC45NzE3NyIKICAgICBpbmtzY2FwZTp3aW5kb3cteD0iMTkxMiIKICAgICBpbmtzY2FwZTp3aW5kb3cteT0iLTgiCiAgICAgaW5rc2NhcGU6d2luZG93LW1heGltaXplZD0iMSIKICAgICBpbmtzY2FwZTpjdXJyZW50LWxheWVyPSJzdmczNCIgLz4KICA8cGF0aAogICAgIGlkPSJyZWN0MjYiCiAgICAgc3R5bGU9ImZpbGw6IHJnYigxMTQsIDEzNywgMjE4KTsiCiAgICAgZD0iTSAxNi4yNzM0MzggMTYuMjczNDM4IEwgMTYuMjczNDM4IDQ4My43MjY1NiBMIDQ4My43MjY1NiA0ODMuNzI2NTYgTCA0ODMuNzI2NTYgMTYuMjczNDM4IEwgMTYuMjczNDM4IDE2LjI3MzQzOCB6IE0gNzcuMTUyMzQ0IDcyLjUgTCA0MjcuNSA3Mi41IEwgNDI3LjUgNDI2LjM3MzA1IEwgNzQuMjQ4MDQ3IDQyNi4zNzMwNSBMIDcyLjUgNDI3LjUgTCA3My4wNDg4MjggNDI2Ljk2Mjg5IEwgNzMuMDQ4ODI4IDM3NS42NjAxNiBMIDExNy4zOTY0OCAzNzUuNjYwMTYgTCAxMTcuMzk2NDggMTIzLjQxOTkyIEwgNzcuMTUyMzQ0IDEyMy40MTk5MiBMIDc3LjE1MjM0NCA3Mi41IHogTSAyNzUgMTI0IEwgMjc1IDI1OSBMIDMwOCAyNTkgTCAzMDggMTI0IEwgMjc1IDEyNCB6IE0gMzUwIDEyNCBMIDM1MCAyNTkgTCAzODMgMjU5IEwgMzgzIDEyNCBMIDM1MCAxMjQgeiAiIC8+Cjwvc3ZnPgo="
                    style="width: 36px;"></a>
                    <a href="https://jinxr.at/donate" target="_blank" style="text-decoration: none; font-weight: 700; color: #777">Buy Me A Coffee</a>
            </div>
        </div>
        <div class="discordance-alerts"></div>
    </form>
</div>