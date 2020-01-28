<?php

namespace Core;

class View {
// allows multiple template use, returns generated string html
// extend core view = no need to repeat template path
    protected $data;

    public function __construct ($data = []) {
        $this->data = $data;
    }

    /**
     * Renders array of $this->>data into template file
     * @param string $template_path
     * returns string Rendered HTML
     */

    public function render($template_path)
    {
        // Check if template exists
        if (!file_exists($template_path))
        {
            throw (new \Exception("Template with filename: "
            . "$template_path does not exist!"));
        }

        // Pass arguments to the Form.tpl.php as $data variable
        // as we require tpl file it's scoped to function's variables

        $data = $this->data;

        // Start buffering output to memory
        ob_start();

        // Load the view (template)
        require $template_path;

        // Return buffered output as string
        return ob_get_clean();
    }
}