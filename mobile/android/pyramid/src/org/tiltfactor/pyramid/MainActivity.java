package org.tiltfactor.pyramid;

import android.os.Bundle;
import android.view.KeyEvent;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.ProgressBar;
import android.app.Activity;

public class MainActivity extends Activity {

	private class OneUpWebViewClient extends WebViewClient {
	    @Override
	    public boolean shouldOverrideUrlLoading(WebView view, String url) {
	        if (url.equals("https://gameServerLocation")) {
	            return false;
	        }
	        Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(url));
	            view.getContext().startActivity(intent);
	            return true;
	    }
	}

	private WebView myWebView;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);

		myWebView = (WebView) findViewById(R.id.pyramid_webview);
		myWebView.loadUrl(getResources().getString(R.string.gameUrl));
		WebSettings webSettings = myWebView.getSettings();
		webSettings.setJavaScriptEnabled(true);
		myWebView.setWebViewClient(new WebViewClient());

		final ProgressBar progressWebView = (ProgressBar) findViewById(R.id.progress_webview);
		myWebView.setWebChromeClient(new WebChromeClient() {
			@Override
			public void onProgressChanged(WebView view, int progress) {
				if(progress < 80){
					progressWebView.setProgress(progress);
				}
				if(progress < 100 && progressWebView.getVisibility() == ProgressBar.GONE){
					progressWebView.setVisibility(ProgressBar.VISIBLE);
                }

                if(progress == 100) {
                	progressWebView.setVisibility(ProgressBar.GONE);

                }
			}
		});
	}


	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
	    // Check if the key event was the Back button and if there's history
	    if ((keyCode == KeyEvent.KEYCODE_BACK) && myWebView.canGoBack()) {
	        myWebView.goBack();
	        return true;
	    }
	    // If it wasn't the Back key or there's no web page history, bubble up to the default
	    // system behavior (probably exit the activity)
	    return super.onKeyDown(keyCode, event);
	}
}
