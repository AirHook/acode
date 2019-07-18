<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');
/**
 * Helper to create PDF files using mpdf.
 *
 * See https://mpdf.github.io/ for more info on mpdf.
 *
 * mPDF is a PHP library which generates PDF files from UTF-8 encoded HTML.
 *
 * @link
 * @package		helpers
 * @author		Webguy
 * @copyright
 * @license
 * @version
 */

 if ( ! function_exists('pdf_create')) {
 	/**
 	 * Create a PDF using mpdf.
 	 *
 	 * @access public
 	 * @param string $html the HTML to render (default: '').
 	 * @param string $filename/$filepath (may have path) optional file name to store the pdf (default: '').
 	 * @param mixed $stream whether or not to stream to browser (default: false).
 	 * @return mixed the raw PDF output if $stream is true, otherwise the PDF is
 	 *         streamed to a file.
 	 */
 	function pdf_create($html = '', $filename = '', $filepath = '', $stream = false, $header_html = '', $footer_html = '')
	{
		$CI =& get_instance();

		// load pertinent library/model/helpers
		$CI->load->library('m_pdf');

		// set headers
		if ($header_html != '') $CI->m_pdf->pdf->SetHTMLHeader($header_html);
		if ($footer_html != '') $CI->m_pdf->pdf->SetHTMLFooter($footer_html);

		// generate pdf from HTML
		$CI->m_pdf->pdf->WriteHTML($html);

		// Output a PDF file directly to the browser
		// Otherwies, set filename and file path
		// $pdf_file_path = 'assets/pdf/pdf_po_selected.pdf';
		if ( ! $stream)
		{
			$CI->m_pdf->pdf->Output();
		}
		else
		{
            // add filepath where necessary
            if ( ! file_exists($filepath))
            {
                $old = umask(0);
                if ( ! mkdir($filepath, 0777, TRUE)) die('Unable to create "'.$filepath.'" folder.');
                umask($old);
            }

			$CI->m_pdf->pdf->Output($filepath.$filename, "F");
		}
 	}
 }
