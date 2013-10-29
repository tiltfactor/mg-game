//
//  ViewController.m
//  pyramid
//
//  Created by Kristina Nenkova on 9/30/13.
//  Copyright (c) 2013 Kristina Nenkova. All rights reserved.
//

#import "ViewController.h"

@interface ViewController ()

@end

@implementation ViewController
@synthesize customWebView;
@synthesize spinner;

- (void)viewDidLoad
{
    [super viewDidLoad];
}
- (void) viewWillAppear:(BOOL)animated {
    
    NSURL *url = [NSURL URLWithString:[NSString stringWithFormat:@"http://10.15.20.154/mgg_test/www/index.php/games/Pyramid"]];
    
    [[NSURLCache sharedURLCache] removeAllCachedResponses];
    
    NSMutableURLRequest *requestObj = [NSMutableURLRequest requestWithURL:url cachePolicy:NSURLRequestReloadIgnoringCacheData timeoutInterval: 10.0];
    [requestObj setCachePolicy:NSURLRequestReloadIgnoringLocalCacheData];
    
    [customWebView loadRequest:requestObj];
    customWebView.delegate =self;
    
    spinner= [[UIActivityIndicatorView alloc]initWithActivityIndicatorStyle:UIActivityIndicatorViewStyleWhiteLarge];
    [spinner setFrame:CGRectMake(self.view.bounds.size.width/2.0-25, self.view.bounds.size.height/2.0-25, 50, 50)];
    [spinner setBackgroundColor:[UIColor colorWithPatternImage:[UIImage imageNamed:@"darkGrey_background.png"]]];
    [customWebView addSubview:spinner];
}
- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}
- (void)webViewDidStartLoad:(UIWebView *)localWebView {
    [spinner startAnimating];
}
- (void)webViewDidFinishLoad:(UIWebView *)localWebView {
    
    [spinner stopAnimating];
}
@end
