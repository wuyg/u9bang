using System; using System.Collections.Generic; using System.ComponentModel; using System.Data; using System.Drawing; using System.Text; using System.Windows.Forms; using System.Data.SqlClient; using System.IO; using System.Xml; using System.Text.RegularExpressions;
using System.Collections;  namespace UFIDA.U9.Helper {     public partial class FrmDBSetting : Form     {         public FrmDBSetting()         {             InitializeComponent();         }
        private Hashtable m_URIAliasMap = new Hashtable();
        private Hashtable m_PageFileMap = new Hashtable();
        private List<PageNodeToc> m_PageNodeTocList = new List<PageNodeToc>();
        private string m_PortalPath = string.Empty;         private void btnSure_Click(object sender, EventArgs e)         {
            this.m_PortalPath = txtPath.Text.Trim();
           // GetPageData();
            this.ParseNodes();
            this.ParseHTMLContent();
            this.PageNodeToDB();         }                                  private void FrmDBSetting_Load(object sender, EventArgs e)         {             lbTitle.Text = PD.Title;
            txtPath.Text = System.Configuration.ConfigurationManager.AppSettings["FilePath"];         }          private void SaveConfig()         {             try             {                 System.Configuration.Configuration config = System.Configuration.ConfigurationManager.OpenExeConfiguration(System.Configuration.ConfigurationUserLevel.None);
                config.AppSettings.Settings["FilePath"].Value = txtPath.Text;                 config.Save();             }             catch             {             }         }                 #region 移动窗体         private bool IsMouseMove = false;         private Point formLocation;         private Point mouseOffset;         private void panelButton_MouseMove(object sender, MouseEventArgs e)         {             int x = 0;             int y = 0;             if (IsMouseMove)             {                 Point pt = Control.MousePosition;                 x = mouseOffset.X - pt.X;                 y = mouseOffset.Y - pt.Y;                 this.Location = new Point(formLocation.X - x, formLocation.Y - y);             }         }          private void panelButton_MouseUp(object sender, MouseEventArgs e)         {             IsMouseMove = false;         }          private void panelButton_MouseDown(object sender, MouseEventArgs e)         {             if (e.Button == System.Windows.Forms.MouseButtons.Left)             {                 IsMouseMove = true;                 formLocation = this.Location;                 mouseOffset = Control.MousePosition;             }         }         #endregion          private void btnClose_Click(object sender, EventArgs e)         {             this.DialogResult = System.Windows.Forms.DialogResult.Cancel;             this.Close();         }          private void btnSelectPath_Click(object sender, EventArgs e)         {             FolderBrowserDialog dia = new FolderBrowserDialog();             dia.ShowNewFolderButton = false;             if (!string.IsNullOrEmpty(txtPath.Text))                 dia.SelectedPath = txtPath.Text;             if (dia.ShowDialog() == System.Windows.Forms.DialogResult.OK)             {                 txtPath.Text = dia.SelectedPath;             }         }         private string ParseHTMLFile(string file)         {             string result = string.Empty;             return result;         }

        private void ParseNodes()
        {
            string mapFilePath = string.Empty;
           
            XmlDocument m_xml = new XmlDocument();
            XmlNodeList nodes;
            
            #region URI And File Map
            m_URIAliasMap = new Hashtable();
            mapFilePath = Path.Combine(m_PortalPath, "help/zh-CN/Data/Alias.xml");
            if (!File.Exists(mapFilePath))
            {
                MessageBox.Show("Alias.xml文件不存在!");
                return;
            }
            m_xml.Load(mapFilePath);
            if (m_xml.HasChildNodes)
            {
                nodes = m_xml.SelectNodes("/CatapultAliasFile/Map");
                if (nodes != null && nodes.Count > 0)
                {
                    string c_uri = string.Empty;
                    string c_link = string.Empty;
                    foreach (XmlNode node in nodes)
                    {
                        c_uri = PubFunction.GetStringValue(node.Attributes["Name"]);
                        c_link = PubFunction.GetStringValue(node.Attributes["Link"]);
                        if (!string.IsNullOrEmpty(c_link) && !string.IsNullOrEmpty(c_uri))
                        {
                            c_uri = c_uri.Replace("__", ".").ToLower();
                            c_link = "Content/" + c_link;
                            m_URIAliasMap[c_link.ToLower()] = c_uri;
                        }
                    }
                }
            }
            #endregion

            #region parse nodes 
            m_xml = new XmlDocument();
            m_PageNodeTocList = new List<PageNodeToc>();
            mapFilePath = Path.Combine(m_PortalPath, "help/zh-CN/Data/Toc.xml");
            if (!File.Exists(mapFilePath))
            {
                MessageBox.Show("Toc.xml文件不存在!");
                return;
            }
            m_xml.Load(mapFilePath);
            if (m_xml.HasChildNodes)
            {
                nodes = m_xml.SelectNodes("/CatapultToc/TocEntry");
                if (nodes != null && nodes.Count > 0)
                {
                    int m_sequence = 0;
                    foreach (XmlNode node in nodes)
                    {
                        ParseNodes(0, node, m_sequence++);
                    }
                }
            }
            #endregion
        }
        private long m_CurrID = 1000000;
        private void ParseNodes(long parentID, XmlNode node,int sequence)
        {
            if (node != null)
            {
                long tempID = m_CurrID++;
                string c_title = PubFunction.GetStringValue(node.Attributes["Title"]);
                string c_link = PubFunction.GetStringValue(node.Attributes["Link"]);
                PageNodeToc pn = new PageNodeToc(tempID, c_title);
                pn.ParentID = parentID;
                if (!string.IsNullOrEmpty(c_link))
                {
                    if (c_link.StartsWith("/")) c_link = c_link.Substring(1);
                    c_link=c_link.ToLower();
                    if (m_URIAliasMap.ContainsKey(c_link))
                    {
                        pn.URI = m_URIAliasMap[c_link].ToString();
                    }
                }
                pn.Link = c_link;
                
                pn.Sequence = sequence;
                if (!string.IsNullOrEmpty(pn.Link))
                    m_PageFileMap[pn.Link] = pn.ID;

                m_PageNodeTocList.Add(pn);
                if (node.ChildNodes != null && node.ChildNodes.Count > 0)
                {
                    int m_sequence=0;
                    foreach (XmlNode n in node.ChildNodes)
                    {
                        ParseNodes(tempID, n, m_sequence++);
                    }
                }
            }
        }
        private void ParseHTMLContent()
        {
            foreach (PageNodeToc pn in m_PageNodeTocList)
            {
                pn.Content = ParseHTMLContent(pn.Link);
            }
        }
        private string ParseHTMLContent(string file)
        {
            string helpFileRoot = Path.Combine(m_PortalPath, "help/zh-CN/");
            helpFileRoot = helpFileRoot.Replace("\\", "/");

            file = Path.Combine(helpFileRoot, file);
            file = file.Replace("\\", "/");

            if (!File.Exists(file)) return string.Empty;

            //父路径
            FileInfo fi = new FileInfo(file);
            string parentPath = fi.DirectoryName.Replace("\\", "/");
            string realPath = string.Empty;
            StreamReader sr = new StreamReader(file);
            string html = sr.ReadToEnd();

            string patten = "(?is)(?<=<body>).*(?=</body>)";
            Regex reg = new Regex(patten, RegexOptions.IgnoreCase);

            Match mt = reg.Match(html);
            html = mt.Value;

            //过滤 标题
            int ind = html.IndexOf("</h1>", StringComparison.OrdinalIgnoreCase);
            if (ind > 0)
            {
                html = html.Substring(ind + 5);
            }
            
            #region 超级连接替换
            patten = "(?<=<a.*?href=\").*?(?=\".*?</a>)";
            reg = new System.Text.RegularExpressions.Regex(patten);
            string newHref=string.Empty;
             MatchCollection matches = reg.Matches(html);
             foreach (Match m in matches)
             {
                 if (m.Value == "javascript:void(0);") continue;
                 if (string.IsNullOrEmpty(m.Value)) continue;
                 if (!(m.Value.EndsWith(".html") || m.Value.EndsWith(".htm"))) continue;

                 realPath = Path.Combine(parentPath, m.Value);
                 
                 if (!File.Exists(realPath)) continue;

                 fi = new FileInfo(realPath);
                 realPath=fi.FullName.Replace("\\", "/");
                 realPath = realPath.Replace(helpFileRoot, "");
                 if (m_PageFileMap[realPath.ToLower()] != null)
                 {
                     html = html.Replace(m.Value, "/help/" + m_PageFileMap[realPath.ToLower()] + ".html");
                 }
             }
            #endregion   
       
             #region IMG src
             patten = "(?<=<img.*?src=\").*?(?=\".*?/>)";
             reg = new System.Text.RegularExpressions.Regex(patten);
             newHref = string.Empty;
             matches = reg.Matches(html);
             foreach (Match m in matches)
             {
                 if (m.Value == "javascript:void(0);") continue;
                 if (string.IsNullOrEmpty(m.Value)) continue;
                 if (!(m.Value.EndsWith(".gif") || m.Value.EndsWith(".jpeg") || m.Value.EndsWith(".jpg") || m.Value.EndsWith(".jpeg"))) continue;

                 realPath = Path.Combine(parentPath, m.Value);
                 if (!File.Exists(realPath)) continue;
                 fi = new FileInfo(realPath);
                 if (m.Value.Contains("/SkinSupport/"))
                 {
                     html = html.Replace(m.Value, "/public/img/help/Images/" + fi.Name);
                     continue;
                 }
                 if (m.Value.Contains("/Resources/Images/"))
                 {
                     html = html.Replace(m.Value, "/public/img/help/Resources/Images/" + fi.Name);
                     continue;
                 }
             }
             #endregion

             #region 收缩和展开
             html = html.Replace("class=\"MCDropDownHotSpot\"", "class=\"MCDropDownHotSpot\"");
             #endregion

             //过滤 script
            patten = "(<script [\\s\\S]+</script>)";
            reg = new Regex(patten, RegexOptions.IgnoreCase);
            html = reg.Replace(html, "");

            patten = "(<(script[\\s\\S]*?)>)";
            reg = new Regex(patten, RegexOptions.IgnoreCase);
            html = reg.Replace(html, "");

            //过滤 <iframe> 标签
            patten = "(<iframe [\\s\\S]+<iframe>)";
            reg = new Regex(patten, RegexOptions.IgnoreCase);
            html = reg.Replace(html, "");

            patten = "(<(iframe [\\s\\S]*?)>)";
            reg = new Regex(patten, RegexOptions.IgnoreCase);
            html = reg.Replace(html, "");

            return html;
        }
        private void PageNodeToDB()
        {
            MySql.Data.MySqlClient.MySqlConnection mysql_Conn = new MySql.Data.MySqlClient.MySqlConnection(PD.MYSQL_ConnectionString);
            mysql_Conn.Open();
            MySql.Data.MySqlClient.MySqlCommand mysql_cmd = mysql_Conn.CreateCommand();
            mysql_cmd.CommandType = CommandType.Text;
            mysql_cmd.Parameters.Clear();
            mysql_cmd.CommandText = "truncate table hp_page";
            mysql_cmd.ExecuteNonQuery();

            mysql_cmd.CommandText = "insert into hp_page(id,page_parent,page_sequence,page_navcode,page_title,page_content) values (@ID,@Parent,@Sequence,@NavCode,@Title,@Content)";
            foreach (PageNodeToc row in m_PageNodeTocList)
            {
                mysql_cmd.Parameters.Clear();
                mysql_cmd.Parameters.AddWithValue("@ID", row.ID);
                mysql_cmd.Parameters.AddWithValue("@Parent", row.ParentID);
                mysql_cmd.Parameters.AddWithValue("@Sequence", row.Sequence);
                mysql_cmd.Parameters.AddWithValue("@NavCode", row.URI);
                mysql_cmd.Parameters.AddWithValue("@Title", row.Title);
                mysql_cmd.Parameters.AddWithValue("@Content", row.Content);
                mysql_cmd.ExecuteNonQuery();
            }
            mysql_cmd.Parameters.Clear();
            mysql_cmd.CommandText = "call p_hp_page_initdata(0) ";
            mysql_cmd.ExecuteNonQuery();
            mysql_cmd.Dispose();
            mysql_Conn.Close();
            mysql_Conn.Dispose();
        }     }
    public class PageNodeToc
    {
        public PageNodeToc() { }
        public PageNodeToc(string title) { this.Title = title; }
        public PageNodeToc(long id, string title) { this.ID = id; this.Title = title; }
        public PageNodeToc(long id, long parentID, string title) { this.ID = id; this.ParentID = parentID; this.Title = title; }
        public long ID { get; set; }
        public string Title { get; set; }
        public string Link { get; set; }
        public string Content { get; set; }
        public string URI { get; set; }
        public long ParentID { get; set; }
        public int Sequence { get; set; }

        public override string ToString()
        {
            return string.Format("Parent:{0} ID:{1} Title:{2}", this.ParentID, this.ID, this.Title);
        }
    } }