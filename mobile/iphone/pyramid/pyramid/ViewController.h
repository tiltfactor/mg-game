//
//  ViewController.h
//  pyramid
//
//  Created by Kristina Nenkova on 9/30/13.
//  Copyright (c) 2013 Kristina Nenkova. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface ViewController : UIViewController <UIWebViewDelegate>
{
    UIWebView *customWebView;
    UIActivityIndicatorView *spinner;
}
@property (nonatomic, retain) IBOutlet UIWebView *customWebView;
@property (nonatomic, retain) UIActivityIndicatorView *spinner;
@end
