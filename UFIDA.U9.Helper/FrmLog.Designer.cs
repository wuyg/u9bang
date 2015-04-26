namespace UFIDA.U9.Helper
{
    partial class FrmLog
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(FrmLog));
            this.panMain = new System.Windows.Forms.Panel();
            this.txtLog = new System.Windows.Forms.RichTextBox();
            this.panBox = new System.Windows.Forms.Panel();
            this.panMain.SuspendLayout();
            this.panBox.SuspendLayout();
            this.SuspendLayout();
            // 
            // panMain
            // 
            this.panMain.BackColor = System.Drawing.Color.White;
            this.panMain.Controls.Add(this.txtLog);
            this.panMain.Dock = System.Windows.Forms.DockStyle.Fill;
            this.panMain.Location = new System.Drawing.Point(0, 0);
            this.panMain.Name = "panMain";
            this.panMain.Size = new System.Drawing.Size(622, 322);
            this.panMain.TabIndex = 4;
            // 
            // txtLog
            // 
            this.txtLog.BackColor = System.Drawing.Color.White;
            this.txtLog.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.txtLog.Dock = System.Windows.Forms.DockStyle.Fill;
            this.txtLog.Location = new System.Drawing.Point(0, 0);
            this.txtLog.Name = "txtLog";
            this.txtLog.ReadOnly = true;
            this.txtLog.Size = new System.Drawing.Size(622, 322);
            this.txtLog.TabIndex = 1;
            this.txtLog.Text = "";
            this.txtLog.WordWrap = false;
            // 
            // panBox
            // 
            this.panBox.BackgroundImageLayout = System.Windows.Forms.ImageLayout.None;
            this.panBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.panBox.Controls.Add(this.panMain);
            this.panBox.Dock = System.Windows.Forms.DockStyle.Fill;
            this.panBox.Location = new System.Drawing.Point(0, 0);
            this.panBox.Name = "panBox";
            this.panBox.Size = new System.Drawing.Size(624, 324);
            this.panBox.TabIndex = 11;
            // 
            // FrmLog
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 12F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(624, 324);
            this.Controls.Add(this.panBox);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "FrmLog";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterParent;
            this.Text = "日志信息";
            this.Load += new System.EventHandler(this.FrmLog_Load);
            this.panMain.ResumeLayout(false);
            this.panBox.ResumeLayout(false);
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.Panel panMain;
        private System.Windows.Forms.Panel panBox;
        private System.Windows.Forms.RichTextBox txtLog;
    }
}